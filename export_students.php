<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use App\Models\Siswa;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$students = Siswa::join('users', 'siswa.user_id', '=', 'users.id')
    ->join('anggota_kelas', 'siswa.id', '=', 'anggota_kelas.siswa_id')
    ->join('kelas', 'anggota_kelas.kelas_id', '=', 'kelas.id')
    ->select('siswa.nama_siswa', 'siswa.nisn', 'kelas.nama_kelas')
    ->get();

$out = "DAFTAR SISWA TERIMPORT:\n\n";
foreach ($students as $s) {
    $out .= "Nama: " . $s->nama_siswa . "\nNISN: " . $s->nisn . "\nKelas: " . $s->nama_kelas . "\n-------------------\n";
}

file_put_contents('imported_students_list.txt', $out);
