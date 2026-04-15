<?php

namespace App\Console\Commands;

use App\Models\Jadwal;
use App\Models\SesiPresensi;
use App\Models\Absensi;
use App\Models\AnggotaKelas;
use App\Models\PointLedger;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MarkAbsentStudents extends Command
{
    /**
     * Nama & signature command.
     * Bisa dipanggil manual lewat: php artisan attendance:mark-absent
     */
    protected $signature = 'attendance:mark-absent';

    /**
     * Deskripsi yang muncul di php artisan list.
     */
    protected $description = 'Cek semua sesi hari ini yang sudah selesai, tandai siswa yang tidak scan sebagai ALPA dan potong poin otomatis.';

    /**
     * Eksekusi command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $now = Carbon::now();
        
        // Konversi nama hari ke bahasa Indonesia
        $hariMap = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu',
        ];
        $hariIni = $hariMap[$today->format('l')] ?? $today->format('l');

        $this->info("🔍 Scanning jadwal hari {$hariIni} yang sudah lewat jam selesai...");

        // 1. Cari semua jadwal hari ini yang jam_selesai sudah lewat
        $jadwals = Jadwal::with('kelas.anggotaKelas.siswa.user')
            ->where('hari', $hariIni)
            ->where('jam_selesai', '<=', $now->format('H:i:s'))
            ->get();

        if ($jadwals->isEmpty()) {
            $this->info("✅ Tidak ada jadwal yang perlu dicek.");
            return 0;
        }

        $totalMarked = 0;

        foreach ($jadwals as $jadwal) {
            // 2. Cari sesi presensi untuk jadwal ini hari ini
            $sesi = SesiPresensi::where('jadwal_id', $jadwal->id)
                ->whereDate('tanggal', $today)
                ->first();

            // Kalau guru belum generate QR (belum bikin sesi), skip
            if (!$sesi) {
                $this->line("  ⏭️  Jadwal #{$jadwal->id} ({$jadwal->kelas->nama_kelas}) — Tidak ada sesi presensi hari ini, skip.");
                continue;
            }

            // 3. Ambil semua siswa di kelas ini
            $anggotaKelas = AnggotaKelas::where('kelas_id', $jadwal->kelas_id)->get();

            // 4. Ambil siswa yang SUDAH absen di sesi ini
            $siswaYangAbsen = Absensi::where('sesi_id', $sesi->id)
                ->pluck('siswa_id')
                ->toArray();

            // 5. Loop setiap anggota kelas, cek yang belum absen
            foreach ($anggotaKelas as $anggota) {
                // Sudah absen? Skip
                if (in_array($anggota->siswa_id, $siswaYangAbsen)) {
                    continue;
                }

                $siswa = $anggota->siswa;
                if (!$siswa || !$siswa->user) continue;

                $user = $siswa->user;

                // 6. Buat record Absensi status ALPA
                Absensi::create([
                    'sesi_id'    => $sesi->id,
                    'siswa_id'   => $siswa->id,
                    'waktu_scan' => null,
                    'status'     => 'alpa',
                    'is_valid'   => false,
                ]);

                // 7. Potong poin (penalti ALPA = -5 poin default)
                $penalty = -5;
                $user->point_balance += $penalty;
                $user->save();

                // 8. Catat ke Ledger
                PointLedger::create([
                    'user_id'          => $user->id,
                    'transaction_type' => 'PENALTY',
                    'amount'           => $penalty,
                    'current_balance'  => $user->point_balance,
                    'description'      => "Auto ALPA: Tidak hadir di {$jadwal->mapel->nama_mapel ?? 'N/A'} ({$jadwal->kelas->nama_kelas})",
                ]);

                $totalMarked++;
                $this->line("  💀 {$user->name} — ALPA di {$jadwal->mapel->nama_mapel ?? 'N/A'} | Poin: {$penalty}");
            }
        }

        $this->info("🏁 Selesai. Total siswa ditandai ALPA: {$totalMarked}");
        Log::info("[AttendanceAutoAlpa] Marked {$totalMarked} students as ALPA on {$today->toDateString()}");
        
        return 0;
    }
}
