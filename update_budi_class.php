<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\Guru;

$budi = Guru::whereHas('user', function($q) { $q->where('serial_number', '123456'); })->first();
$newClass = Kelas::where('nama_kelas', 'XII PPLG-RPL 2')->first();

if ($budi && $newClass) {
    $count = Jadwal::where('guru_id', $budi->id)->update(['kelas_id' => $newClass->id]);
    echo "Updated {$count} schedules for Budi to class: XII PPLG-RPL 2\n";
} else {
    echo "Error: Budi or XII PPLG-RPL 2 not found.\n";
}
