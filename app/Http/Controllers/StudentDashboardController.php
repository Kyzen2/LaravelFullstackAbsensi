<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\SesiPresensi;
use App\Models\FlexibilityItem;
use App\Models\PointLedger;
use App\Models\UserToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    /**
     * Menampilkan halaman utama Dashboard Siswa.
     * Mengambil data absen terbaru dan statistik kehadiran siswa yang login.
     */
    public function index()
    {
        // Mengambil profil siswa yang sedang login
        $siswa = Auth::user()->siswa;
        
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil Siswa tidak ditemukan.');
        }

        // Mengambil 5 data absensi terbaru milik siswa ini
        // Eager loading 'sesi.jadwal.mapel' digunakan agar data mata pelajaran ikut terbawa
        $recentAttendance = Absensi::with(['sesi.jadwal.mapel'])
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->take(5)
            ->get();

        // Menghitung statistik sederhana: total absen dan absen khusus bulan ini
        $stats = [
            'total_absen' => Absensi::where('siswa_id', $siswa->id)->count(),
            'absen_bulan_ini' => Absensi::where('siswa_id', $siswa->id)
                ->whereMonth('waktu_scan', now()->month)
                ->whereYear('waktu_scan', now()->year)
                ->count(),
        ];

        // GAMIFICATION DATA
        $user = Auth::user();
        $pointBalance = $user->point_balance;
        $ledgers = PointLedger::where('user_id', $user->id)->latest()->take(10)->get();
        $marketItems = FlexibilityItem::where('is_active', true)->get();
        $inventory = UserToken::with('item')->where('user_id', $user->id)->latest()->get();

        // LEADERBOARD: Top 10 siswa dengan poin tertinggi
        $leaderboard = User::where('role', 'siswa')
            ->where('point_balance', '>', 0)
            ->orderByDesc('point_balance')
            ->take(10)
            ->get();
        
        // Cari ranking user saat ini
        $myRank = User::where('role', 'siswa')
            ->where('point_balance', '>', $user->point_balance)
            ->count() + 1;

        return view('student.dashboard', compact('recentAttendance', 'stats', 'pointBalance', 'ledgers', 'marketItems', 'inventory', 'leaderboard', 'myRank'));
    }

    /**
     * Membeli Token Kelonggaran di Marketplace menggunakan Poin
     */
    public function buyToken(Request $request, FlexibilityItem $item)
    {
        $user = Auth::user();

        // 1. Cek Saldo
        if ($user->point_balance < $item->point_cost) {
            return back()->with('error', 'Saldo poin tidak cukup untuk membeli token ini.');
        }

        // 2. Cek Limit Stok / Bulan (jika disetting admin)
        if ($item->stock_limit !== null) {
            $boughtThisMonth = UserToken::where('user_id', $user->id)
                ->where('item_id', $item->id)
                ->whereMonth('created_at', now()->month)
                ->count();
            
            if ($boughtThisMonth >= $item->stock_limit) {
                return back()->with('error', 'Kamu sudah mencapai batas maksmimal pembelian token ini di bulan ini.');
            }
        }

        // 3. Proses Pembayaran
        $user->point_balance -= $item->point_cost;
        $user->save();

        // 4. Catat Mutasi Ledger
        PointLedger::create([
            'user_id' => $user->id,
            'transaction_type' => 'SPEND',
            'amount' => -$item->point_cost,
            'current_balance' => $user->point_balance,
            'description' => "Membeli Token: " . $item->item_name
        ]);

        // 5. Masukkan Token ke Tas (Inventory) Siswa
        UserToken::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'status' => 'AVAILABLE'
        ]);

        return back()->with('success', 'Yeay! Token "' . $item->item_name . '" berhasil dibeli dan masuk ke dompetmu.');
    }

    /**
     * Membuka halaman scan QR Code.
     * Halaman ini biasanya berisi logic JavaScript untuk mengakses kamera.
     */
    public function scan()
    {
        return view('student.scan');
    }

    /**
     * Menampilkan riwayat (history) seluruh absensi siswa.
     */
    public function history()
    {
        $siswa = Auth::user()->siswa;
        
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil Siswa tidak ditemukan.');
        }
        
        // Mengambil data absensi dengan sistem pagination (pembagian per halaman)
        // Di sini diatur 15 data per halaman agar loading tidak berat
        $attendanceHistory = Absensi::with(['sesi.jadwal.mapel'])
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->paginate(15);

        return view('student.history', compact('attendanceHistory'));
    }
}
