<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Siswa;
use App\Models\Kelas;

$targetClass = "XII PPLG-RPL 2";
$kelas = Kelas::where('nama_kelas', $targetClass)->first();

if (!$kelas) {
    echo "Class not found.\n";
    exit;
}

echo "Students in class: $targetClass (ID: {$kelas->id})\n";
$students = Siswa::whereIn('id', function($query) use ($kelas) {
    $query->select('siswa_id')
        ->from('anggota_kelas')
        ->where('kelas_id', $kelas->id);
})->get();

foreach ($students as $s) {
    echo "- ID: {$s->id}, Name: {$s->nama_siswa}, NISN: {$s->nisn}\n";
}
