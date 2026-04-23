<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::create([
    'name'          => 'Budi Santoso (Admin 2)',
    'email'         => 'admin2@sekolah.com',
    'password'      => Hash::make('password'),
    'role'          => 'admin',
    'serial_number' => 'ADM-' . strtoupper(substr(md5(time()), 0, 8)),
]);

echo "Sukses! Akun Admin ke-2 berhasil dibuat.\n";
echo "Nama  : " . $user->name . "\n";
echo "Email : " . $user->email . "\n";
echo "Pass  : password\n";
