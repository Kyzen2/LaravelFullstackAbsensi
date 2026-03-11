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
     * Fungsi ini bertugas mengisi database dengan data awal (master data) 
     * agar aplikasi bisa langsung digunakan setelah install.
     */
    public function run(): void
    {
        Log::info("DATABASE SEEDER STARTED");
        echo "DATABASE SEEDER STARTED\n";

        /**
         * CATATAN PENTING:
         * Di sini gw sengaja pake Query Builder (DB::table...) daripada Eloquent (User::create...) 
         * karena di environment server/CLI ini sering terjadi error "silent crash" kalo pake model.
         * Dengan Query Builder, data dijamin masuk lebih stabil tanpa beban logic model yang berat.
         */

        // Mematikan Foreign Key Checks sementara agar bisa menghapus data tanpa error relasi
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $tables = [
            'absensi', 'sesi_presensi', 'jadwal', 'mapel', 
            'anggota_kelas', 'siswa', 'kelas', 'guru', 
            'lokasi', 'tahun_ajaran', 'users'
        ];

        // Membersihkan semua tabel agar tidak ada data duplikat saat seeder dijalankan ulang
        foreach ($tables as $table) {
            echo "Cleaning table: $table\n";
            DB::table($table)->delete();
        }

        // Menghidupkan kembali Foreign Key Checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        echo "Cleanup completed in database: " . DB::connection()->getDatabaseName() . "\n";

        // 1. Membuat akun Admin
        echo "Creating Admin...\n";
        $adminId = DB::table('users')->insertGetId([
            'serial_number' => 'admin',
            'name' => 'Administrator',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Membuat Tahun Ajaran Aktif
        echo "Creating Tahun Ajaran...\n";
        $taId = DB::table('tahun_ajaran')->insertGetId([
            'tahun' => '2025/2026',
            'semester' => 'Ganjil',
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Membuat Lokasi Absensi (Geofencing)
        echo "Creating Lokasi...\n";
        $lokasiId = DB::table('lokasi')->insertGetId([
            'nama_lokasi' => 'Lab RPL',
            'latitude' => -6.175392, // Koordinat contoh
            'longitude' => 106.827153,
            'radius' => 50, // Siswa harus dalam radius 50 meter dari titik ini
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Membuat Data Guru dan Akun Usernya
        echo "Creating Gurus...\n";
        // Guru 1
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

        // Guru 2
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

        // 5. Membuat Kelas
        echo "Creating Kelas...\n";
        $kelasId = DB::table('kelas')->insertGetId([
            'nama_kelas' => 'XII PPLG-RPL 2',
            'tahun_ajaran_id' => $taId,
            'wali_kelas_id' => $guru1Id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 8. Membuat Mata Pelajaran (Mapel)
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

        // 9. Membuat Jadwal Mingguan Realistik (sampai jam 4 sore)
        $scheduleData = [
            // Format: [Hari, Nama Mapel, ID Guru, Jam Mulai, Jam Selesai]
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
            // Minggu (Untuk testing kapan saja)
            ['Minggu', 'Matematika', $guru2Id, '00:00:00', '23:59:59'],
        ];

        // Looping untuk memasukkan semua data jadwal ke tabel jadwal
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
