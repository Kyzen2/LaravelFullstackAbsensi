<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\SesiPresensi;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TeacherDashboardController extends Controller
{
    /**
     * Menampilkan halaman utama Dashboard Guru.
     * Fungsi ini mengambil jadwal mengajar, menghitung statistik harian,
     * dan menentukan kelas mana yang sedang aktif saat ini.
     */
    public function index()
    {
        // Mengambil data guru yang sedang login
        $guru = Auth::user()->guru;
        
        if (!$guru) {
            return redirect()->route('dashboard')->with('error', 'Profil Guru tidak ditemukan.');
        }

        // Mendapatkan nama hari dalam Bahasa Indonesia (Senin, Selasa, dst)
        $hariIni = $this->getHariIndonesia(now()->format('l'));
        // Mendapatkan jam sekarang (format 24 jam)
        $sekarang = now()->format('H:i:s');
        
        // Mengambil SEMUA jadwal mengajar guru ini, diurutkan berdasarkan hari dan jam mulai
        // eager loading 'with' digunakan untuk efisiensi database (mengurangi query)
        $schedules = Jadwal::with(['kelas', 'mapel', 'lokasi'])
            ->where('guru_id', $guru->id)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai')
            ->get();

        // Filter jadwal khusus hari ini saja
        $todaySchedules = $schedules->where('hari', $hariIni);
        
        // Cari jadwal berikutnya (jadwal pertama hari ini yang jam mulainya > jam sekarang)
        $nextSchedule = $todaySchedules->where('jam_mulai', '>', $sekarang)->first();

        // Cari jadwal yang sedang aktif sekarang (jam_mulai <= sekarang <= jam_selesai)
        $currentSchedule = $todaySchedules->where('jam_mulai', '<=', $sekarang)
            ->where('jam_selesai', '>=', $sekarang)
            ->first();

        // Menghitung jumlah siswa yang sudah absen hari ini untuk semua sesi guru ini
        $todayStats = [
            'total_absen' => Absensi::whereHas('sesi', function($q) use ($guru) {
                $q->whereHas('jadwal', function($sq) use ($guru) {
                    $sq->where('guru_id', $guru->id);
                })->where('tanggal', now()->format('Y-m-d'));
            })->count()
        ];

        // Mengirim data ke view (halaman blade)
        return view('teacher.dashboard', compact('schedules', 'todayStats', 'nextSchedule', 'hariIni', 'currentSchedule'));
    }

    /**
     * Mengarahkan guru ke halaman QR Code untuk kelas yang sedang aktif saat ini.
     */
    public function currentQr()
    {
        $guru = Auth::user()->guru;
        if (!$guru) {
            return redirect()->route('dashboard')->with('error', 'Profil Guru tidak ditemukan.');
        }

        $hariIni = $this->getHariIndonesia(now()->format('l'));
        $sekarang = now()->format('H:i:s');

        // Cari jadwal yang aktif detik ini
        $jadwal = Jadwal::where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->where('jam_mulai', '<=', $sekarang)
            ->where('jam_selesai', '>=', $sekarang)
            ->first();

        // Jika tidak ada kelas yang sedang berjalan, tampilkan halaman error "Gak ada kelas"
        if (!$jadwal) {
            return view('teacher.qr-not-found');
        }

        // Ambil sesi presensi hari ini, kalau belum ada otomatis DIBUAT (firstOrCreate)
        // Token QR dibuat random untuk keamanan agar tidak bisa ditebak siswa
        $sesi = SesiPresensi::firstOrCreate(
            [
                'jadwal_id' => $jadwal->id,
                'tanggal' => now()->format('Y-m-d'),
            ],
            [
                'token_qr' => Str::random(40),
            ]
        );

        return view('teacher.qr-current', compact('sesi', 'jadwal'));
    }

    /**
     * Memperbarui (refresh) token QR Code secara dinamis.
     * Digunakan agar QR Code berubah terus dalam beberapa menit (opsional).
     */
    public function refreshToken(SesiPresensi $sesi)
    {
        // Validasi: hanya guru pemilik jadwal yang boleh refresh token
        $guru = Auth::user()->guru;
        if (!$guru || $sesi->jadwal->guru_id !== $guru->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Update token dengan string random baru
        $sesi->update([
            'token_qr' => Str::random(40)
        ]);

        // Kembalikan response JSON (untuk diproses oleh JavaScript di frontend)
        return response()->json([
            'token' => $sesi->token_qr
        ]);
    }

    /**
     * Menghasilkan QR Code untuk jadwal tertentu.
     */
    public function generateQr(Jadwal $jadwal)
    {
        // Cek apakah sesi untuk hari ini sudah ada
        $sesi = SesiPresensi::where('jadwal_id', $jadwal->id)
            ->where('tanggal', now()->format('Y-m-d'))
            ->first();

        // Jika belum ada sesi (misalnya guru klik manual dari jadwal), buat baru
        if (!$sesi) {
            $sesi = SesiPresensi::create([
                'jadwal_id' => $jadwal->id,
                'tanggal' => now()->format('Y-m-d'),
                'token_qr' => Str::random(40),
            ]);
        }

        return view('teacher.qr-display', compact('sesi', 'jadwal'));
    }

    /**
     * Menampilkan daftar jadwal mengajar hari ini.
     */
    public function schedule()
    {
        $guru = Auth::user()->guru;
        if (!$guru) {
            return redirect()->route('dashboard')->with('error', 'Profil Guru tidak ditemukan.');
        }

        $hariIni = $this->getHariIndonesia(now()->format('l'));

        $schedules = Jadwal::with(['kelas', 'mapel', 'lokasi'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();

        return view('teacher.schedule', compact('schedules', 'hariIni'));
    }

    /**
     * Halaman Rekap/Daftar Kelas untuk manajemen absensi manual.
     */
    public function attendanceIndex(Request $request)
    {
        $search = $request->input('search');
        
        // Mengambil semua kelas, bisa difilter lewat pencarian (search)
        // Diurutkan agar kelas XII PPLG-RPL 2 selalu muncul paling atas (prioritas user)
        $classes = Kelas::with(['tahunAjaran', 'waliKelas'])
            ->when($search, function($query) use ($search) {
                $query->where('nama_kelas', 'like', "%{$search}%");
            })
            ->orderByRaw("CASE WHEN nama_kelas = 'XII PPLG-RPL 2' THEN 0 ELSE 1 END")
            ->orderBy('nama_kelas')
            ->get();

        return view('teacher.attendance.index', compact('classes', 'search'));
    }

    /**
     * Menampilkan detail absensi untuk kelas tertentu.
     */
    public function classAttendanceDetail(Kelas $kelas)
    {
        // Mengambil daftar siswa yang terdaftar di kelas ini menggunakan subquery
        $students = Siswa::whereIn('id', function($query) use ($kelas) {
            $query->select('siswa_id')
                ->from('anggota_kelas')
                ->where('kelas_id', $kelas->id);
        })->get();

        $guru = Auth::user()->guru;

        // Cari apakah ada sesi yang AKTIF hari ini untuk kelas ini (oleh guru yang sedang login)
        $todaySesi = SesiPresensi::whereHas('jadwal', function($q) use ($kelas, $guru) {
                $q->where('kelas_id', $kelas->id)
                  ->where('guru_id', $guru->id);
            })
            ->where('tanggal', now()->format('Y-m-d'))
            ->first();

        // Kalau ada sesi aktif hari ini, langsung redirect ke detail sesi tersebut
        if ($todaySesi) {
            return redirect()->route('teacher.session.detail', $todaySesi);
        }

        // Kalau gak ada yang aktif hari ini, tampilkan daftar sesi-sesi sebelumnya (History Sesi)
        $sessions = SesiPresensi::whereHas('jadwal', function($q) use ($kelas, $guru) {
                $q->where('kelas_id', $kelas->id)
                  ->where('guru_id', $guru->id);
            })
            ->with('jadwal.mapel')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('teacher.attendance.class-sessions', compact('kelas', 'students', 'sessions'));
    }

    /**
     * Menampilkan detail daftar hadir siswa dalam satu sesi tertentu.
     * Di sini guru bisa melihat siapa saja yang sudah scan dan siapa yang belum.
     */
    public function sessionDetail(SesiPresensi $sesi)
    {
        $jadwal = $sesi->jadwal;
        $guru = Auth::user()->guru;

        // Keamanan: Pastikan guru yang akses adalah pemilik jadwal tersebut
        if (!$guru || $jadwal->guru_id !== $guru->id) {
            abort(403);
        }

        // Ambil daftar siswa kelas tersebut
        $students = Siswa::whereIn('id', function($query) use ($jadwal) {
            $query->select('siswa_id')
                ->from('anggota_kelas')
                ->where('kelas_id', $jadwal->kelas_id);
        })->get();

        // Ambil data absensi yang sudah ada (Hadir, Sakit, dsb) untuk sesi ini
        $attendance = Absensi::where('sesi_id', $sesi->id)->get()->keyBy('siswa_id');

        return view('teacher.session-detail', compact('sesi', 'jadwal', 'students', 'attendance'));
    }

    /**
     * Menyimpan absensi manual (saat guru input Sakit, Izin, atau Alpha).
     */
    public function storeManualAttendance(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'sesi_id' => 'required|exists:sesi_presensi,id',
            'siswa_id' => 'required|exists:siswa,id',
            'status' => 'required|in:hadir,sakit,izin,alpha'
        ]);

        $sesi = SesiPresensi::findOrFail($request->sesi_id);
        $guru = Auth::user()->guru;
        if (!$guru || $sesi->jadwal->guru_id !== $guru->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Update atau Create: kalau data sudah ada di-update, kalau belum dibuat baru
        $absensi = Absensi::updateOrCreate(
            ['sesi_id' => $sesi->id, 'siswa_id' => $request->siswa_id],
            [
                'status' => $request->status,
                'waktu_scan' => now(),
                'is_valid' => true
            ]
        );

        return response()->json(['success' => true, 'status' => $absensi->status]);
    }

    /**
     * Menghasilkan file PDF Rekap Absensi untuk satu Mata Pelajaran (Jadwal).
     */
    public function exportPdf(Jadwal $jadwal)
    {
        if ($jadwal->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }

        // Load semua relasi yang dibutuhkan agar data lengkap
        $jadwal->load(['kelas.tahunAjaran', 'mapel', 'guru', 'lokasi']);

        // Siswa di kelas ini
        $students = Siswa::whereIn('id', function($query) use ($jadwal) {
            $query->select('siswa_id')
                ->from('anggota_kelas')
                ->where('kelas_id', $jadwal->kelas_id);
        })->get();

        // Ambil semua sesi yang pernah terjadi untuk jadwal ini
        $sessions = SesiPresensi::where('jadwal_id', $jadwal->id)->get();
        $sessionCount = $sessions->count();
        
        // Olah data: hitung Sakit berapa kali, Izin berapa kali per siswa
        $attendanceData = [];
        foreach ($students as $student) {
            $records = Absensi::whereIn('sesi_id', $sessions->pluck('id'))
                ->where('siswa_id', $student->id)
                ->get();
            
            $attendanceData[$student->id] = [
                'nama' => $student->nama_siswa,
                'hadir' => $records->where('status', 'hadir')->count(),
                'sakit' => $records->where('status', 'sakit')->count(),
                'izin' => $records->where('status', 'izin')->count(),
                'alpha' => $records->where('status', 'alpha')->count(),
                'total_pertemuan' => $sessionCount
            ];
        }

        // Generate PDF menggunakan library DomPDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('teacher.report-pdf', compact('jadwal', 'attendanceData'));
        // Download file otomatis
        return $pdf->download('Report-' . $jadwal->mapel->nama_mapel . '-' . $jadwal->kelas->nama_kelas . '.pdf');
    }

    /**
     * Helper Static untuk mengubah hari English ke Indonesia.
     */
    public static function getHariIndonesiaStatic($day)
    {
        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        return $days[$day] ?? $day;
    }

    private function getHariIndonesia($day)
    {
        return self::getHariIndonesiaStatic($day);
    }
}
