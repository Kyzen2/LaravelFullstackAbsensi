<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\Guru;

$out = "";
$out .= "--- GURU ---\n";
foreach (Guru::all() as $g) {
    $out .= "ID: {$g->id} | Nama: {$g->nama_guru}\n";
}

$out .= "\n--- KELAS ---\n";
foreach (Kelas::all() as $k) {
    $out .= "ID: {$k->id} | Nama: {$k->nama_kelas} | Tahun ID: {$k->tahun_ajaran_id}\n";
}

$out .= "\n--- JADWAL (Budi/123456) ---\n";
$budi = Guru::whereHas('user', function($q) { $q->where('serial_number', '123456'); })->first();
if ($budi) {
    foreach (Jadwal::where('guru_id', $budi->id)->with('kelas')->get() as $j) {
        $out .= "Jadwal ID: {$j->id} | Kelas: {$j->kelas->nama_kelas} | Hari: {$j->hari}\n";
    }
}

$out .= "\n--- SISWA COUNT PER KELAS ---\n";
foreach (Kelas::all() as $k) {
    $count = \App\Models\AnggotaKelas::where('kelas_id', $k->id)->count();
    $out .= "Kelas: {$k->nama_kelas} | Siswa: {$count}\n";
}

$out .= "\n--- RECENT 5 SISWA ---\n";
foreach (Siswa::latest()->limit(5)->get() as $s) {
    $out .= "Siswa: {$s->nama_siswa} | NISN: {$s->nisn}\n";
}

file_put_contents('debug_output.txt', $out);
echo "Debug output written to debug_output.txt\n";
