<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::where('email', 'admin2@sekolah.com')->first();

if ($user) {
    echo "=== Info Login Admin 2 ===\n";
    echo "Serial Number : " . $user->serial_number . "\n";
    echo "Password      : password\n";
} else {
    echo "User tidak ditemukan.\n";
}
