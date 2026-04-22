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
        $lateness = $waktuScan->diffInMinutes($jamMulai, false) * -1;

        // ==========================================
        // AUTO-TOKEN INTERCEPTOR (Penyelamat)
        // ==========================================
        // Jika murid telat, cek dulu apakah dia mau pake Token sakti buat hapus hukuman
        if ($lateness > 0) { 
            $activeToken = UserToken::where('user_id', $user->id)
                ->where('status', 'AVAILABLE')
                ->whereHas('item', function($q) {
                    $q->where('item_name', 'like', '%Bebas Telat%')
                      ->orWhere('item_name', 'like', '%Kompensasi%');
                })->first();

            if ($activeToken) {
                $activeToken->update([
                    'status' => 'USED',
                    'used_at_attendance_id' => $absensi->id
                ]);
                
                $absensi->update(['status' => 'hadir (token used)']);
                return; // STOP: Murid aman, gak perlu cek rule pinalti lagi.
            }
        }

        // ==========================================
        // DYNAMIC RULE ENGINE POIN
        // ==========================================
        $rules = PointRule::where('is_active', true)
            ->where('target_role', $user->role)
            ->get();
        
        $hasPenalty = false;

        foreach ($rules as $rule) {
            $isMatch = false;

            if (str_contains($rule->condition_value, ':')) {
                $format = substr_count($rule->condition_value, ':') == 1 ? 'H:i' : 'H:i:s';
                $targetTime = Carbon::createFromFormat($format, trim($rule->condition_value));
                $targetStr = $targetTime->format('H:i:s');
                $scanStr = $waktuScan->format('H:i:s');
                
                if ($rule->condition_operator == '<' && $scanStr < $targetStr) $isMatch = true;
                if ($rule->condition_operator == '>' && $scanStr > $targetStr) $isMatch = true;
                if ($rule->condition_operator == '=' && $scanStr == $targetStr) $isMatch = true;
            } else {
                $value = (int) $rule->condition_value;
                if ($rule->condition_operator == '>' && $lateness > $value) $isMatch = true;
                if ($rule->condition_operator == '<' && $lateness < $value) $isMatch = true;
            }

            if ($isMatch) {
                $user->point_balance += $rule->point_modifier;
                $user->save();

                PointLedger::create([
                    'user_id' => $user->id,
                    'transaction_type' => $rule->point_modifier >= 0 ? 'EARN' : 'PENALTY',
                    'amount' => $rule->point_modifier,
                    'current_balance' => $user->point_balance,
                    'description' => "System Rule: " . $rule->rule_name
                ]);

                // JIKA ADMIN NGASIH POIN MINUS, BARU KITA CAP 'TERLAMBAT'
                if ($rule->point_modifier < 0) {
                    $hasPenalty = true;
                }
            }
        }

        if ($hasPenalty) {
            $absensi->update(['status' => 'terlambat']);
        }
    }
}
