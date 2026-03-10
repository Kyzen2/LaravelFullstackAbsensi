<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Siswa;
use App\Models\User;

$results = [];

$students = Siswa::where('nama_siswa', 'like', '%Andi%')->get();
foreach ($students as $s) {
    $class = $s->anggotaKelas->first()->kelas->nama_kelas ?? 'NONE';
    $results[] = "SISWA - ID: {$s->id}, Name: {$s->nama_siswa}, NISN: {$s->nisn}, Class: $class";
}

$users = User::where('name', 'like', '%Andi%')->get();
foreach ($users as $u) {
    $results[] = "USER - ID: {$u->id}, Name: {$u->name}, Serial: {$u->serial_number}, Role: {$u->role}";
}

file_put_contents('find_andi_result.txt', implode("\n", $results));
echo "Found " . count($results) . " items.";
