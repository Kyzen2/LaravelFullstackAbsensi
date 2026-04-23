<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HelpdeskTicket;
use App\Models\HelpdeskResponse;
use Illuminate\Support\Facades\Auth;

class AdminHelpdeskController extends Controller
{
    // FITUR 1 & 3: Admin Dashboard untuk analitik dan Manajemen SLA (Antrean)
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'month');
        $query = HelpdeskTicket::query();

        if ($filter == 'today') {
            $query->whereDate('created_at', \Carbon\Carbon::today());
        } elseif ($filter == 'week') {
            $query->whereBetween('created_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()]);
        } elseif ($filter == 'month') {
            $query->whereMonth('created_at', \Carbon\Carbon::now()->month)
                  ->whereYear('created_at', \Carbon\Carbon::now()->year);
        }

        $tickets = (clone $query)->with(['user'])
                    ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
                    ->orderBy('created_at', 'asc')
                    ->get();
        
        // Top 5 Operator (Berdasarkan filter)
        $topOperators = \App\Models\User::where('role', 'admin')
            ->withCount(['handledTickets as resolved_count' => function ($q) use ($query) {
                $q->whereIn('status', ['resolved', 'closed']);
                if (request('filter') == 'today') {
                    $q->whereDate('updated_at', \Carbon\Carbon::today());
                } elseif (request('filter') == 'week') {
                    $q->whereBetween('updated_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()]);
                } elseif (request('filter') == 'month') {
                    $q->whereMonth('updated_at', \Carbon\Carbon::now()->month);
                }
            }])
            ->orderByDesc('resolved_count')
            ->take(5)
            ->get();

        $totalGlobalMinutes = 0;
        $totalGlobalTickets = 0;

        foreach ($topOperators as $op) {
            $responses = \App\Models\HelpdeskResponse::where('user_id', $op->id)
                ->with('ticket')
                ->get()
                ->groupBy('ticket_id');
                
            $totalMinutes = 0;
            $ticketCount = 0;
            
            foreach ($responses as $ticketId => $ticketResponses) {
                $firstResponse = $ticketResponses->sortBy('created_at')->first();
                $ticket = $firstResponse->ticket;
                if ($ticket) {
                    $diffInMinutes = $ticket->created_at->diffInMinutes($firstResponse->created_at);
                    $totalMinutes += $diffInMinutes;
                    $ticketCount++;
                    
                    $totalGlobalMinutes += $diffInMinutes;
                    $totalGlobalTickets++;
                }
            }
            
            $op->avg_response_minutes = $ticketCount > 0 ? round($totalMinutes / $ticketCount) : 0;
            $op->performance_bar = min(100, max(5, ($op->avg_response_minutes / 60) * 100));
        }

        $globalAvgResponse = $totalGlobalTickets > 0 ? round($totalGlobalMinutes / $totalGlobalTickets) : 0;

        $stats = [
            'open' => (clone $query)->where('status', 'open')->count(),
            'in_progress' => (clone $query)->where('status', 'in_progress')->count(),
            'resolved' => (clone $query)->where('status', 'resolved')->count(),
            'avg_rating' => number_format((clone $query)->whereNotNull('rating')->avg('rating') ?? 0, 1),
            'avg_response_time' => $globalAvgResponse . ' Menit',
        ];

        return view('admin.helpdesk.index', compact('tickets', 'stats', 'topOperators', 'filter'));
    }

    // Laporan / Cetak Rekap untuk Kepala Sekolah
    public function printReport(Request $request)
    {
        $filter = $request->query('filter', 'month');
        $query = HelpdeskTicket::query();

        if ($filter == 'today') {
            $query->whereDate('created_at', \Carbon\Carbon::today());
            $periode = "Hari Ini (" . \Carbon\Carbon::today()->format('d M Y') . ")";
        } elseif ($filter == 'week') {
            $query->whereBetween('created_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()]);
            $periode = "Minggu Ini";
        } else {
            $query->whereMonth('created_at', \Carbon\Carbon::now()->month)
                  ->whereYear('created_at', \Carbon\Carbon::now()->year);
            $periode = "Bulan " . \Carbon\Carbon::now()->translatedFormat('F Y');
        }

        $tickets = $query->with(['user', 'operator'])
                    ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin.helpdesk.print', compact('tickets', 'periode'));
    }

    public function show(HelpdeskTicket $ticket)
    {
        $ticket->load('responses.user', 'user', 'operator');
        return view('admin.helpdesk.show', compact('ticket'));
    }

    // Komunikasi dua arah (Operator menjawab Pelapor)
    public function reply(Request $request, HelpdeskTicket $ticket)
    {
        $request->validate(['message' => 'required|string']);

        // Jika pertama kali membalas, otomatis klaim tiket (jadi Operator) dan ubah status
        if ($ticket->status === 'open') {
            $ticket->update([
                'status' => 'in_progress',
                'operator_id' => Auth::id()
            ]);
        }

        HelpdeskResponse::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    // Operator mengubah status kendala (open -> resolved dll)
    public function updateStatus(Request $request, HelpdeskTicket $ticket)
    {
        $request->validate(['status' => 'required|in:open,in_progress,resolved,closed']);
        
        $ticket->update(['status' => $request->status]);
        
        return back()->with('success', 'Status tiket berhasil diperbarui menjadi ' . strtoupper($request->status));
    }
}
