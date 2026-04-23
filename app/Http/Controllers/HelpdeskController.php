<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HelpdeskTicket;
use App\Models\HelpdeskResponse;
use Illuminate\Support\Facades\Auth;

class HelpdeskController extends Controller
{
    public function index()
    {
        $tickets = HelpdeskTicket::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        
        $stats = [
            'total' => $tickets->count(),
            'in_progress' => $tickets->whereIn('status', ['open', 'in_progress'])->count(),
            'resolved' => $tickets->whereIn('status', ['resolved', 'closed'])->count(),
        ];

        return view('helpdesk.index', compact('tickets', 'stats'));
    }

    public function create()
    {
        return view('helpdesk.create');
    }

    // FITUR 2: Anti-Duplikasi (Full-Text Search)
    public function searchSimilar(Request $request)
    {
        $query = $request->input('q');
        if (strlen($query) < 3) {
            return response()->json([]);
        }

        // Mencari kemiripan pada Subject dan Description menggunakan algoritma BOOLEAN MODE MySQL
        $similar = HelpdeskTicket::whereRaw('MATCH(subject, description) AGAINST (? IN BOOLEAN MODE)', [$query . '*'])
                    ->select('id', 'subject', 'status')
                    ->limit(5)
                    ->get();
                    
        return response()->json($similar);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high'
        ]);

        // FITUR ANTI-DUPLIKASI (HARD BLOCK JIKA MASIH OPEN ATAU IN_PROGRESS)
        $existingOpenTicket = HelpdeskTicket::where('user_id', Auth::id())
            ->where('subject', $request->subject)
            ->whereIn('status', ['open', 'in_progress'])
            ->first();

        if ($existingOpenTicket) {
            return back()->withInput()->with('error', 'DITOLAK: Anda memiliki tiket dengan judul persis ("' . $request->subject . '") yang masih dalam status ' . strtoupper($existingOpenTicket->status) . '. Harap tunggu penyelesaian dari Operator.');
        }

        $ticket = HelpdeskTicket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'open'
        ]);

        // AUTO-REPLY: Balasan otomatis pertama kali dari sistem
        $adminOperator = \App\Models\User::where('role', 'admin')->first();
        if ($adminOperator) {
            HelpdeskResponse::create([
                'ticket_id' => $ticket->id,
                'user_id'   => $adminOperator->id,
                'message'   => 'Terima kasih atas laporan Anda. Tiket aduan Anda telah kami terima dan tercatat dalam sistem dengan nomor #HLP-' . str_pad($ticket->id, 4, '0', STR_PAD_LEFT) . '. Tim operator kami akan segera meninjau dan menindaklanjuti kendala yang Anda alami. Mohon menunggu, kami akan membalas secepatnya.'
            ]);
        }

        return redirect()->route('helpdesk.show', $ticket->id)->with('success', 'Tiket aduan berhasil dikirim.');
    }

    public function show(HelpdeskTicket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) abort(403);
        $ticket->load('responses.user', 'operator');
        return view('helpdesk.show', compact('ticket'));
    }

    public function reply(Request $request, HelpdeskTicket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) abort(403);
        
        $request->validate(['message' => 'required|string']);

        HelpdeskResponse::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        return back()->with('success', 'Pesan terkirim ke Operator.');
    }

    // FITUR 1: Memberikan rating setelah tiket selesai
    public function rate(Request $request, HelpdeskTicket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) abort(403);
        if ($ticket->status !== 'resolved' && $ticket->status !== 'closed') {
            return back()->with('error', 'Hanya bisa memberi rating pada tiket yang sudah selesai.');
        }
        
        $request->validate(['rating' => 'required|integer|min:1|max:5']);
        
        // Simpan ke kolom rating di tiket (untuk menjaga kompatibilitas UI)
        $ticket->update(['rating' => $request->rating]);

        // Simpan ke tabel ke-3 (satisfaction_ratings) sesuai standarisasi database
        \Illuminate\Support\Facades\DB::table('satisfaction_ratings')->updateOrInsert(
            ['ticket_id' => $ticket->id],
            [
                'rating' => $request->rating,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        return back()->with('success', 'Terima kasih atas penilaian Anda terhadap layanan kami.');
    }
}
