<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "Starting aggressive wipe...\n";

Schema::disableForeignKeyConstraints();
$tables = ['absensi', 'sesi_presensi', 'jadwal', 'mapel', 'anggota_kelas', 'siswa', 'kelas', 'guru', 'lokasi', 'tahun_ajaran', 'users'];

foreach ($tables as $table) {
    echo "Truncating $table... ";
    DB::table($table)->truncate();
    $count = DB::table($table)->count();
    echo "Count now: $count\n";
}

Schema::enableForeignKeyConstraints();

echo "Verifying Andi Pratama specifically...\n";
$andi = DB::table('siswa')->where('nama_siswa', 'like', '%Andi%')->count();
echo "Andi count in siswa: $andi\n";

$andiUser = DB::table('users')->where('name', 'like', '%Andi%')->get();
echo "Users with name Andi: " . $andiUser->count() . "\n";
foreach ($andiUser as $u) {
    echo "- ID: {$u->id}, Name: {$u->name}\n";
}

echo "Done.\n";
