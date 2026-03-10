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
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-students {class_name=XII PPLG-RPL 2} {--password=password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import student data from Zilabs API for a specific class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('memory_limit', '1G');
        $targetClass = trim($this->argument('class_name'));
        $this->info("Fetching data from API for class: $targetClass...");
        
        $logFile = storage_path('logs/student_import.log');
        file_put_contents($logFile, "Starting import for: $targetClass\n");

        try {
            $response = Http::timeout(120)->get('https://zieapi.zielabs.id/api/getsiswa', [
                'tahun' => '2025'
            ]);

            if (!$response->successful()) {
                $msg = "Failed to fetch data from API. Status: " . $response->status();
                $this->error($msg);
                file_put_contents($logFile, $msg . "\n", FILE_APPEND);
                return 1;
            }

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

            // Filter data with trim and case-insensitive check
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

            // Get active Tahun Ajaran
            $ta = TahunAjaran::where('status', true)->first();
            if (!$ta) {
                $this->error("No active Tahun Ajaran found. Please seed the database first.");
                return 1;
            }

            // Get or create Kelas
            $guru = DB::table('guru')->first();
            if (!$guru) {
                $this->error("No Guru found. Please seed the database first.");
                return 1;
            }

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
            $kelas = (object)['id' => $kelasId];

            $bar = $this->output->createProgressBar($count);
            $bar->start();

            $password = $this->option('password');

            foreach ($filtered as $student) {
                DB::transaction(function () use ($student, $kelasId, $password) {
                    $nisn = trim($student['nisn']);
                    $nama = trim($student['nama']);

                    // 1. Create/Update User
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

                    // 2. Create/Update Siswa
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

                    // 3. Associate with Class
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
