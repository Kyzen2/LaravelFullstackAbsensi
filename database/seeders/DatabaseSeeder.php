<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Lokasi;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Jadwal;
use App\Models\AnggotaKelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Log::info("DATABASE SEEDER STARTED");
        echo "DATABASE SEEDER STARTED\n";

        // Toggle FK checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $tables = [
            'absensi', 'sesi_presensi', 'jadwal', 'mapel', 
            'anggota_kelas', 'siswa', 'kelas', 'guru', 
            'lokasi', 'tahun_ajaran', 'users'
        ];

        foreach ($tables as $table) {
            echo "Cleaning table: $table\n";
            DB::table($table)->delete();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        echo "Cleanup completed in database: " . DB::connection()->getDatabaseName() . "\n";

        // 1. Admin
        echo "Creating Admin...\n";
        $adminId = DB::table('users')->insertGetId([
            'serial_number' => 'admin',
            'name' => 'Administrator',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Tahun Ajaran
        echo "Creating Tahun Ajaran...\n";
        $taId = DB::table('tahun_ajaran')->insertGetId([
            'tahun' => '2025/2026',
            'semester' => 'Ganjil',
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Lokasi
        echo "Creating Lokasi...\n";
        $lokasiId = DB::table('lokasi')->insertGetId([
            'nama_lokasi' => 'Lab RPL',
            'latitude' => -6.175392,
            'longitude' => 106.827153,
            'radius' => 50,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Guru
        echo "Creating Gurus...\n";
        $userGuru1Id = DB::table('users')->insertGetId([
            'serial_number' => '123456',
            'name' => 'Budi M.Kom',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $guru1Id = DB::table('guru')->insertGetId([
            'user_id' => $userGuru1Id,
            'nama_guru' => 'Budi M.Kom',
            'nip' => '123456',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $userGuru2Id = DB::table('users')->insertGetId([
            'serial_number' => '654321',
            'name' => 'Siti S.Pd',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $guru2Id = DB::table('guru')->insertGetId([
            'user_id' => $userGuru2Id,
            'nama_guru' => 'Siti S.Pd',
            'nip' => '654321',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Kelas
        echo "Creating Kelas...\n";
        $kelasId = DB::table('kelas')->insertGetId([
            'nama_kelas' => 'XII PPLG-RPL 2',
            'tahun_ajaran_id' => $taId,
            'wali_kelas_id' => $guru1Id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 8. Mapel
        echo "Creating Mapels...\n";
        $mapels = [
            'Pemrograman Web' => $guru1Id,
            'Basis Data' => $guru1Id,
            'PBO (Java)' => $guru1Id,
            'Bahasa Indonesia' => $guru2Id,
            'Matematika' => $guru2Id,
            'Bahasa Inggris' => $guru2Id,
            'PKN' => $guru2Id,
            'PJOK (Olahraga)' => $guru2Id,
        ];

        $mapelIds = [];
        foreach ($mapels as $name => $guruId) {
            $mapelIds[$name] = DB::table('mapel')->insertGetId([
                'nama_mapel' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 9. Jadwal (Realistic Weekly Schedule until 4 PM)
        $scheduleData = [
            // Senin
            ['Senin', 'Pemrograman Web', $guru1Id, '07:30:00', '12:00:00'],
            ['Senin', 'Bahasa Indonesia', $guru2Id, '13:00:00', '16:00:00'],
            // Selasa
            ['Selasa', 'Basis Data', $guru1Id, '07:30:00', '12:00:00'],
            ['Selasa', 'PBO (Java)', $guru1Id, '13:00:00', '16:00:00'],
            ['Selasa', 'Matematika', $guru2Id, '07:30:00', '11:00:00'],
            ['Selasa', 'Bahasa Inggris', $guru2Id, '12:00:00', '16:00:00'],
            // Rabu
            ['Rabu', 'PBO (Java)', $guru1Id, '07:30:00', '11:00:00'],
            ['Rabu', 'Bahasa Inggris', $guru2Id, '11:30:00', '14:00:00'],
            ['Rabu', 'PKN', $guru2Id, '14:30:00', '16:00:00'],
            // Kamis
            ['Kamis', 'Pemrograman Web', $guru1Id, '07:30:00', '12:00:00'],
            ['Kamis', 'PKN', $guru2Id, '13:00:00', '16:00:00'],
            // Jumat
            ['Jumat', 'PJOK (Olahraga)', $guru2Id, '07:30:00', '11:30:00'],
            ['Jumat', 'Basis Data', $guru1Id, '13:30:00', '16:00:00'],
            // Sabtu
            ['Sabtu', 'PBO (Java)', $guru1Id, '07:30:00', '11:00:00'],
            ['Sabtu', 'Matematika', $guru2Id, '12:00:00', '16:00:00'],
            // Minggu (Testing)
            ['Minggu', 'Matematika', $guru2Id, '00:00:00', '23:59:59'],
        ];

        foreach ($scheduleData as $data) {
            DB::table('jadwal')->insert([
                'kelas_id' => $kelasId,
                'mapel_id' => $mapelIds[$data[1]],
                'guru_id' => $data[2],
                'lokasi_id' => $lokasiId,
                'hari' => $data[0],
                'jam_mulai' => $data[3],
                'jam_selesai' => $data[4],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        echo "Jadwal creation completed\n";
    }
}
