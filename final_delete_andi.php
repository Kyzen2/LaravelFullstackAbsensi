<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Siswa;
use App\Models\User;
use App\Models\AnggotaKelas;
use Illuminate\Support\Facades\DB;

DB::transaction(function() {
    $students = Siswa::where('nama_siswa', 'like', '%Andi Pratama%')->get();
    foreach ($students as $s) {
        AnggotaKelas::where('siswa_id', $s->id)->delete();
        $s->delete();
    }
    User::where('name', 'like', '%Andi Pratama%')->delete();
    User::where('serial_number', '223344')->delete();
});

echo "Deleted.";
