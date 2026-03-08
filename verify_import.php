<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use App\Models\Siswa;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$students = Siswa::take(10)->get();

if ($students->isEmpty()) {
    echo "NO STUDENTS FOUND" . PHP_EOL;
} else {
    foreach ($students as $s) {
        echo "NAMA: " . $s->nama_siswa . " | NISN: " . $s->nisn . PHP_EOL;
    }
}
