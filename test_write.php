<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = User::create([
    'name' => 'Test Student',
    'serial_number' => 'TEST12345',
    'password' => Hash::make('password'),
    'role' => 'siswa',
]);

Siswa::create([
    'user_id' => $user->id,
    'nisn' => 'TEST12345',
    'nama_siswa' => 'Test Student',
]);

echo "DONE. NEW COUNT: " . Siswa::count();
file_put_contents('final_check.txt', "NEW COUNT: " . Siswa::count());
