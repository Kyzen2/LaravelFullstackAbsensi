<?php

namespace App\Services;

use App\Models\Absensi;
use App\Models\PointRule;
use App\Models\PointLedger;
use App\Models\UserToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AttendancePointService
{
    /**
     * Mengevaluasi absensi yang baru dibuat.
     * Menerapkan Rule Engine Poin dan Otomatisasi Token Kelonggaran.
     */
    public function evaluateAttendance(Absensi $absensi)
    {
        $user = $absensi->siswa->user; // Relasi ke tabel user melalui siswa
        $jadwal = $absensi->sesi->jadwal;
        
        $waktuScan = Carbon::parse($absensi->waktu_scan);
        $jamMulai = Carbon::parse($jadwal->jam_mulai);
        
        // 1. Hitung Lateness (Keterlambatan dalam menit)
        // Jika scan = 07:45, jam_mulai = 07:30, maka lateness = 15. Minus berarti datang lebih awal.
        $lateness = $waktuScan->diffInMinutes($jamMulai, false) * -1;

        // ==========================================
        // AUTO-TOKEN INTERCEPTOR
        // ==========================================
        // Jika user telat (lateness bernilai positif)
        if ($lateness > 0) { 
            // Cek apakah dia punya token aktif untuk kelonggaran
            $activeToken = UserToken::where('user_id', $user->id)
                ->where('status', 'AVAILABLE')
                ->whereHas('item', function($q) {
                    // Cari item token yang namanya mengandung unsur kompensasi
                    $q->where('item_name', 'like', '%Bebas Telat%')
                      ->orWhere('item_name', 'like', '%Kompensasi%');
                })->first();

            // Jika ada token, langsung pakai
            if ($activeToken) {
                $activeToken->update([
                    'status' => 'USED',
                    'used_at_attendance_id' => $absensi->id
                ]);
                
                // Ubah status absen jadi hadir dengan catatan
                $absensi->update([
                    'status' => 'hadir (token used)'
                ]);

                // Hentikan eksekusi, user tidak kena penalti poin aturan karena saktinya token.
                return;
            } else {
                // Tidak punya token, update status jadi terlambat
                $absensi->update(['status' => 'terlambat']);
            }
        }

        // ==========================================
        // DYNAMIC RULE ENGINE POIN
        // ==========================================
        // Cari semua rule yang aktif untuk role user (contoh: "siswa")
        $rules = PointRule::where('is_active', true)
            ->where('target_role', $user->role)
            ->get();
        
        $rulesApplied = [];

        foreach ($rules as $rule) {
            $isMatch = false;

            // Jika nilai kondisinya berupa waktu presisi (contoh: "06:30" atau "06:30:00")
            if (str_contains($rule->condition_value, ':')) {
                $format = substr_count($rule->condition_value, ':') == 1 ? 'H:i' : 'H:i:s';
                $targetTime = Carbon::createFromFormat($format, trim($rule->condition_value));
                
                $targetStr = $targetTime->format('H:i:s');
                $scanStr = $waktuScan->format('H:i:s');
                
                if ($rule->condition_operator == '<' && $scanStr < $targetStr) $isMatch = true;
                if ($rule->condition_operator == '>' && $scanStr > $targetStr) $isMatch = true;
                if ($rule->condition_operator == '=' && $scanStr == $targetStr) $isMatch = true;
            } 
            // Jika kondisinya berupa range/jumlah menit (contoh: "15" menit)
            else {
                $value = (int) $rule->condition_value;
                if ($rule->condition_operator == '>' && $lateness > $value) $isMatch = true;
                if ($rule->condition_operator == '<' && $lateness < $value) $isMatch = true;
            }

            // Jika Match, simpan rule ini untuk dieksekusi poinya
            if ($isMatch) {
                $rulesApplied[] = $rule;
            }
        }

        // Jika ada aturan yang cocok, catat ke Ledger dan tambah poin user
        if (count($rulesApplied) > 0) {
            foreach($rulesApplied as $rule) {
                $transactionType = $rule->point_modifier >= 0 ? 'EARN' : 'PENALTY';
                
                // Update Saldo Poin User Database
                $user->point_balance += $rule->point_modifier;
                $user->save();

                // Catat transaksi mutasi ke buku besar
                PointLedger::create([
                    'user_id' => $user->id,
                    'transaction_type' => $transactionType,
                    'amount' => $rule->point_modifier,
                    'current_balance' => $user->point_balance,
                    'description' => "System Rule Match: " . $rule->rule_name . " (Absen ID: " . $absensi->id . ")"
                ]);
            }
        }
    }
}
