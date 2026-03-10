<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Models\User;

Schema::disableForeignKeyConstraints();
DB::table('absensi')->truncate();
DB::table('sesi_presensi')->truncate();
DB::table('jadwal')->truncate();
DB::table('mapel')->truncate();
DB::table('anggota_kelas')->truncate();
DB::table('siswa')->truncate();
DB::table('kelas')->truncate();
DB::table('guru')->truncate();
DB::table('lokasi')->truncate();
DB::table('tahun_ajaran')->truncate();
DB::table('users')->truncate();
Schema::enableForeignKeyConstraints();

$counts = [
    'siswa' => Siswa::count(),
    'users' => User::count(),
];

file_put_contents('wipe_verify.json', json_encode($counts));
echo "Wipe complete. Counts: " . json_encode($counts);
