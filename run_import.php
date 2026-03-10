<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
ini_set('memory_limit', '2G');
set_time_limit(0);
ob_start();

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\AnggotaKelas;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

$targetClass = "XII PPLG-RPL 2";
$password = "password";

try {
    $response = Http::timeout(120)->get('https://zieapi.zielabs.id/api/getsiswa', ['tahun' => '2025']);
    if (!$response->successful()) {
        die("API Error: " . $response->status());
    }

    $json = $response->json();
    $data = $json['data'];
    $allRombels = array_unique(array_column($data, 'nama_rombel'));
    echo "Sample Rombels from API:\n";
    foreach (array_slice($allRombels, 0, 10) as $r) {
        echo "[$r] (len: " . strlen($r) . ")\n";
    }

    $filtered = array_filter($data, function ($item) use ($targetClass) {
        return trim($item['nama_rombel'] ?? '') === $targetClass;
    });

    echo "Found " . count($filtered) . " students.\n";

    $ta = TahunAjaran::where('status', true)->first();
    if (!$ta) die("No active TA");

    $guru = DB::table('guru')->first();
    if (!$guru) die("No Guru found");

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

    foreach ($filtered as $student) {
        DB::transaction(function () use ($student, $kelas, $password) {
            $user = User::updateOrCreate(['serial_number' => $student['nisn']], [
                'name' => $student['nama'],
                'password' => Hash::make($password),
                'role' => 'siswa',
            ]);
            $siswa = Siswa::updateOrCreate(['user_id' => $user->id], [
                'nisn' => $student['nisn'],
                'nama_siswa' => $student['nama'],
            ]);
            AnggotaKelas::updateOrCreate(['siswa_id' => $siswa->id, 'kelas_id' => $kelas->id]);
        });
    }
    echo "Import done. Total Siswa now: " . Siswa::count() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
file_put_contents('debug_import.txt', ob_get_clean());
