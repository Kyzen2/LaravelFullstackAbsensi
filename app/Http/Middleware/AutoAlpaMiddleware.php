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
        // Jalankan pengecekan ALPA setiap request (Hapus Cache sementara untuk Debugging)
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

        \Log::info("=== AUTO-ALPA SCAN START [{$hariIni} {$now->format('H:i:s')}] ===");

        // Cari jadwal hari ini yang jam_selesai sudah lewat
        $jadwals = Jadwal::with(['kelas.anggotaKelas.siswa.user', 'mapel'])
            ->where('hari', $hariIni)
            ->where('jam_selesai', '<=', $now->format('H:i:s'))
            ->get();

        \Log::info("  Menemukan " . $jadwals->count() . " jadwal selesai hari ini.");

        foreach ($jadwals as $jadwal) {
            \Log::info("  Processing Jadwal: " . ($jadwal->mapel->nama_mapel ?? 'N/A') . " di " . $jadwal->kelas->nama_kelas . " (Selesai: {$jadwal->jam_selesai})");
            
            // Buat/cari sesi presensi hari ini untuk jadwal ini
            $sesi = SesiPresensi::firstOrCreate(
                ['jadwal_id' => $jadwal->id, 'tanggal' => $today->toDateString()],
                ['token_qr' => 'AUTO-ALPA-' . Str::random(8)]
            );

            // Siswa yang sudah punya record absensi (hadir/terlambat/alpa/apapun)
            $sudahAdaRecord = Absensi::where('sesi_id', $sesi->id)->pluck('siswa_id')->toArray();

            // Loop anggota kelas, cari yang belum ada record sama sekali
            if (!$jadwal->kelas || !$jadwal->kelas->anggotaKelas || $jadwal->kelas->anggotaKelas->isEmpty()) {
                \Log::warning("    Skip: Tidak ada anggota kelas di " . $jadwal->kelas->nama_kelas);
                continue;
            }
            
            foreach ($jadwal->kelas->anggotaKelas as $anggota) {
                if (in_array($anggota->siswa_id, $sudahAdaRecord)) {
                    // \Log::info("    Siswa ID {$anggota->siswa_id} sudah ada record, skip.");
                    continue;
                }

                $siswa = $anggota->siswa;
                if (!$siswa || !$siswa->user) {
                    \Log::error("    Siswa ID {$anggota->siswa_id} data user/siswa corrupt!");
                    continue;
                }
                
                $user = $siswa->user;

                \Log::info("    🔥 Marking ALPA: {$user->name}");

                // Buat record ALPA
                Absensi::create([
                    'sesi_id' => $sesi->id,
                    'siswa_id' => $siswa->id,
                    'waktu_scan' => null,
                    'status' => 'alpa',
                    'is_valid' => false,
                ]);

                // Potong poin -5
                $user->point_balance -= 5;
                $user->save();

                // Catat ke Ledger
                PointLedger::create([
                    'user_id' => $user->id,
                    'transaction_type' => 'PENALTY',
                    'amount' => -5,
                    'current_balance' => $user->point_balance,
                    'description' => "Auto ALPA: Tidak hadir - " . ($jadwal->mapel->nama_mapel ?? 'N/A') . " ({$jadwal->kelas->nama_kelas})",
                ]);
            }
        }
        
        \Log::info("=== AUTO-ALPA SCAN END ===");
    }
}
