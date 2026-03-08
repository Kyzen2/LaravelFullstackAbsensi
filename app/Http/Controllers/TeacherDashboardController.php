<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\SesiPresensi;
use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        $hariIni = $this->getHariIndonesia(now()->format('l'));
        $sekarang = now()->format('H:i:s');
        
        // Get all schedules for this teacher
        $schedules = Jadwal::with(['kelas', 'mapel', 'lokasi'])
            ->where('guru_id', $guru->id)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai')
            ->get();

        // Get only today's schedule to find the "next" one
        $todaySchedules = $schedules->where('hari', $hariIni);
        
        // Find next schedule (first today where jam_mulai > now)
        $nextSchedule = $todaySchedules->where('jam_mulai', '>', $sekarang)->first();

        // Find current schedule (happening now)
        $currentSchedule = $todaySchedules->where('jam_mulai', '<=', $sekarang)
            ->where('jam_selesai', '>=', $sekarang)
            ->first();

        // Count total students present today for this teacher
        $todayStats = [
            'total_absen' => Absensi::whereHas('sesi', function($q) use ($guru) {
                $q->whereHas('jadwal', function($sq) use ($guru) {
                    $sq->where('guru_id', $guru->id);
                })->where('tanggal', now()->format('Y-m-d'));
            })->count()
        ];

        return view('teacher.dashboard', compact('schedules', 'todayStats', 'nextSchedule', 'hariIni', 'currentSchedule'));
    }

    public function currentQr()
    {
        $guru = Auth::user()->guru;
        $hariIni = $this->getHariIndonesia(now()->format('l'));
        $sekarang = now()->format('H:i:s');

        // Find active schedule right now
        $jadwal = Jadwal::where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->where('jam_mulai', '<=', $sekarang)
            ->where('jam_selesai', '>=', $sekarang)
            ->first();

        if (!$jadwal) {
            return view('teacher.qr-not-found');
        }

        // Get or create session for today
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

    public function refreshToken(SesiPresensi $sesi)
    {
        // Only owner can refresh
        if ($sesi->jadwal->guru_id !== Auth::user()->guru->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $sesi->update([
            'token_qr' => Str::random(40)
        ]);

        return response()->json([
            'token' => $sesi->token_qr
        ]);
    }

    public function generateQr(Jadwal $jadwal)
    {
        // Check if session already exists for today
        $sesi = SesiPresensi::where('jadwal_id', $jadwal->id)
            ->where('tanggal', now()->format('Y-m-d'))
            ->first();

        if (!$sesi) {
            $sesi = SesiPresensi::create([
                'jadwal_id' => $jadwal->id,
                'tanggal' => now()->format('Y-m-d'),
                'token_qr' => Str::random(40),
            ]);
        }

        return view('teacher.qr-display', compact('sesi', 'jadwal'));
    }

    public function schedule()
    {
        $guru = Auth::user()->guru;
        $hariIni = $this->getHariIndonesia(now()->format('l'));

        $schedules = Jadwal::with(['kelas', 'mapel', 'lokasi'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();

        return view('teacher.schedule', compact('schedules', 'hariIni'));
    }

    public function sessionDetail(SesiPresensi $sesi)
    {
        $jadwal = $sesi->jadwal;
        if ($jadwal->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }

        // Fetch students in this class
        $students = Siswa::whereIn('id', function($query) use ($jadwal) {
            $query->select('siswa_id')
                ->from('anggota_kelas')
                ->where('kelas_id', $jadwal->kelas_id);
        })->get();

        // Get existing attendance for this session
        $attendance = Absensi::where('sesi_id', $sesi->id)->get()->keyBy('siswa_id');

        return view('teacher.session-detail', compact('sesi', 'jadwal', 'students', 'attendance'));
    }

    public function storeManualAttendance(Request $request)
    {
        $request->validate([
            'sesi_id' => 'required|exists:sesi_presensi,id',
            'siswa_id' => 'required|exists:siswa,id',
            'status' => 'required|in:hadir,sakit,izin,alpha'
        ]);

        $sesi = SesiPresensi::findOrFail($request->sesi_id);
        if ($sesi->jadwal->guru_id !== Auth::user()->guru->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

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

    public function exportPdf(Jadwal $jadwal)
    {
        if ($jadwal->guru_id !== Auth::user()->guru->id) {
            abort(403);
        }

        $jadwal->load(['kelas.tahunAjaran', 'mapel', 'guru', 'lokasi']);

        $students = Siswa::whereIn('id', function($query) use ($jadwal) {
            $query->select('siswa_id')
                ->from('anggota_kelas')
                ->where('kelas_id', $jadwal->kelas_id);
        })->get();

        $sessions = SesiPresensi::where('jadwal_id', $jadwal->id)->get();
        $sessionCount = $sessions->count();
        
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

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('teacher.report-pdf', compact('jadwal', 'attendanceData'));
        return $pdf->download('Report-' . $jadwal->mapel->nama_mapel . '-' . $jadwal->kelas->nama_kelas . '.pdf');
    }

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
