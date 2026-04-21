<?php

namespace App\Http\Middleware;

use App\Models\Jadwal;
use App\Models\SesiPresensi;
use App\Models\Absensi;
use App\Models\PointLedger;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AutoAlpaMiddleware
{
    /**
     * Middleware ini berjalan otomatis di background setiap kali ada user buka halaman.
     * Pakai cache supaya gak berat — hanya jalan sekali tiap 10 menit.
     */
    public function handle(Request $request, Closure $next)
    {
        // Jalankan pengecekan ALPA langsung setiap request tanpa cache biar bener-bener otomatis & real-time
        $this->runAlpaScan();

        return $next($request);
    }

    private function runAlpaScan()
    {
        $today = Carbon::today();
        $now = Carbon::now();

        $hariMap = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu',
        ];
        $hariIni = $hariMap[$today->format('l')] ?? $today->format('l');

        // Cari jadwal hari ini yang jam_selesai sudah lewat
        $jadwals = Jadwal::with(['kelas.anggotaKelas.siswa.user', 'mapel'])
            ->where('hari', $hariIni)
            ->where('jam_selesai', '<=', $now->format('H:i:s'))
            ->get();

        foreach ($jadwals as $jadwal) {
            // Buat/cari sesi presensi hari ini untuk jadwal ini
            $sesi = SesiPresensi::firstOrCreate(
                ['jadwal_id' => $jadwal->id, 'tanggal' => $today->toDateString()],
                ['token_qr' => 'AUTO-ALPA-' . Str::random(8)]
            );

            // Ambil daftar siswa yang sudah punya record (hadir/terlambat/alpa)
            $sudahAdaRecord = Absensi::where('sesi_id', $sesi->id)->pluck('siswa_id')->toArray();

            if (!$jadwal->kelas || !$jadwal->kelas->anggotaKelas) continue;
            
            foreach ($jadwal->kelas->anggotaKelas as $anggota) {
                if (in_array($anggota->siswa_id, $sudahAdaRecord)) continue;

                $siswa = $anggota->siswa;
                if (!$siswa || !$siswa->user) continue;
                $user = $siswa->user;

                // Eksekusi Penalty ALPA
                Absensi::create([
                    'sesi_id' => $sesi->id,
                    'siswa_id' => $siswa->id,
                    'waktu_scan' => null,
                    'status' => 'alpa',
                    'is_valid' => false,
                ]);

                $user->point_balance -= 5;
                $user->save();

                PointLedger::create([
                    'user_id' => $user->id,
                    'transaction_type' => 'PENALTY',
                    'amount' => -5,
                    'current_balance' => $user->point_balance,
                    'description' => "Auto ALPA: Kelewat jadwal " . ($jadwal->mapel->nama_mapel ?? 'N/A'),
                ]);

                \Log::info("[AutoAlpa] Marked {$user->name} as ALPA for {$jadwal->mapel->nama_mapel}");
            }
        }
    }
}
