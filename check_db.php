<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\SesiPresensi;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "Current Sessions:\n";
$sessions = SesiPresensi::with('jadwal.guru')->get();
foreach ($sessions as $s) {
    echo "ID: {$s->id}, Guru: {$s->jadwal->guru->nama_guru} (ID: {$s->jadwal->guru_id})\n";
}

echo "\nCurrent Teachers:\n";
$teachers = Guru::all();
foreach ($teachers as $t) {
    echo "ID: {$t->id}, Name: {$t->nama_guru}, User ID: {$t->user_id}\n";
}

echo "\nCurrent Users:\n";
$users = User::all();
foreach ($users as $u) {
    echo "ID: {$u->id}, Name: {$u->name}, Role: {$u->role}\n";
}
