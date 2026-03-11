<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\AnggotaKelas;
use App\Models\TahunAjaran;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ImportStudents extends Command
{
    /**
     * Konfigurasi Command: Nama command dan parameter yang diterima.
     * Jalankan lewat: php artisan app:import-students "NAMA KELAS" --password=...
     */
    protected $signature = 'app:import-students {class_name=XII PPLG-RPL 2} {--password=password}';

    /**
     * Deskripsi singkat tentang apa yang dilakukan perintah ini.
     */
    protected $description = 'Import student data from Zilabs API for a specific class';

    /**
     * Titik awal eksekusi command.
     */
    public function handle()
    {
        // Set limit memory agar proses data besar tidak crash
        ini_set('memory_limit', '1G');
        $targetClass = trim($this->argument('class_name'));
        $this->info("Fetching data from API for class: $targetClass...");
        
        $logFile = storage_path('logs/student_import.log');
        file_put_contents($logFile, "Starting import for: $targetClass\n");

        try {
            // Tahap 1: Mengambil data dari API eksternal menggunakan library HTTP Laravel (Guzzle)
            $response = Http::timeout(120)->get('https://zieapi.zielabs.id/api/getsiswa', [
                'tahun' => '2025'
            ]);

            if (!$response->successful()) {
                $msg = "Failed to fetch data from API. Status: " . $response->status();
                $this->error($msg);
                file_put_contents($logFile, $msg . "\n", FILE_APPEND);
                return 1;
            }

            // Tahap 2:Parsing JSON dan filter data sesuai nama kelas yang di-input
            $json = $response->json();
            if (!isset($json['data'])) {
                $msg = "Error: 'data' key not found in API response.";
                $this->error($msg);
                file_put_contents($logFile, $msg . "\n", FILE_APPEND);
                return 1;
            }

            $data = $json['data'];
            $total = count($data);
            $this->info("Total records received: $total");
            file_put_contents($logFile, "Total records received: $total\n", FILE_APPEND);

            // Filter siswa yang 'nama_rombel'-nya pas dengan target class kita
            $filtered = array_filter($data, function ($item) use ($targetClass) {
                if (!isset($item['nama_rombel'])) return false;
                return trim($item['nama_rombel']) === $targetClass || 
                       strtoupper(trim($item['nama_rombel'])) === strtoupper($targetClass);
            });

            $count = count($filtered);
            if ($count === 0) {
                $this->warn("No students found for class: $targetClass");
                return 0;
            }

            $this->info("Found $count students. Starting import...");

            // Tahap 3: Persiapan database (Cari Tahun Ajaran dan Guru)
            $ta = TahunAjaran::where('status', true)->first();
            if (!$ta) {
                $this->error("No active Tahun Ajaran found. Please seed the database first.");
                return 1;
            }

            $guru = DB::table('guru')->first();
            if (!$guru) {
                $this->error("No Guru found. Please seed the database first.");
                return 1;
            }

            // Cari ID Kelas, kalau belum ada dibuat dulu
            $kelasId = DB::table('kelas')->where('nama_kelas', $targetClass)->value('id');
            if (!$kelasId) {
                $kelasId = DB::table('kelas')->insertGetId([
                    'nama_kelas' => $targetClass,
                    'tahun_ajaran_id' => $ta->id,
                    'wali_kelas_id' => $guru->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Progress Bar untuk tampilan di terminal
            $bar = $this->output->createProgressBar($count);
            $bar->start();

            $password = $this->option('password');

            // Tahap 4: Import Looping dengan Database Transaction
            // Transaction memastikan data masuk SEKALIGUS (User + Siswa + Anggota). 
            // Kalau satu error, semuanya dibatalkan agar database tetap bersih.
            foreach ($filtered as $student) {
                DB::transaction(function () use ($student, $kelasId, $password) {
                    $nisn = trim($student['nisn']);
                    $nama = trim($student['nama']);

                    // a. Create/Update Akun User (identitas utama login)
                    $userId = DB::table('users')->where('serial_number', $nisn)->value('id');
                    if (!$userId) {
                        $userId = DB::table('users')->insertGetId([
                            'serial_number' => $nisn,
                            'name' => $nama,
                            'password' => Hash::make($password),
                            'role' => 'siswa',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        DB::table('users')->where('id', $userId)->update([
                            'name' => $nama,
                            'updated_at' => now(),
                        ]);
                    }

                    // b. Create/Update Profil Siswa (data tambahan NISN, dsb)
                    $siswaId = DB::table('siswa')->where('user_id', $userId)->value('id');
                    if (!$siswaId) {
                        $siswaId = DB::table('siswa')->insertGetId([
                            'user_id' => $userId,
                            'nisn' => $nisn,
                            'nama_siswa' => $nama,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        DB::table('siswa')->where('id', $siswaId)->update([
                            'nama_siswa' => $nama,
                            'updated_at' => now(),
                        ]);
                    }

                    // c. Hubungkan Siswa ke Kelas (Mapping Anggota Kelas)
                    DB::table('anggota_kelas')->updateOrInsert(
                        [
                            'siswa_id' => $siswaId,
                            'kelas_id' => $kelasId
                        ],
                        [
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                });
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            $this->info("Successfully imported $count students into '$targetClass'.");

        } catch (\Exception $e) {
            $this->error("An error occurred: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
