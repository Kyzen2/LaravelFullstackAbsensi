<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$serialNumber = '0081506973';
$user = User::where('serial_number', $serialNumber)->with('siswa')->first();

$out = "";
if ($user) {
    $out .= "USER FOUND: " . $user->name . "\n";
    $out .= "ROLE: " . $user->role . "\n";
    $out .= "SERIAL NUMBER: " . $user->serial_number . "\n";
    $out .= "PASSWORD CHECK ('password'): " . (Hash::check('password', $user->password) ? 'MATCH' : 'FAIL') . "\n";
    if ($user->siswa) {
        $out .= "SISWA NAME: " . $user->siswa->nama_siswa . "\n";
        $out .= "SISWA NISN: " . $user->siswa->nisn . "\n";
    } else {
        $out .= "NO ASSOCIATED SISWA RECORD FOUND!\n";
    }
} else {
    $out .= "USER NOT FOUND with serial_number: $serialNumber\n";
    // Check all users with serial_number
    $out .= "\nTOTAL USERS: " . User::count() . "\n";
    $out .= "SAMPLE USERS:\n";
    foreach (User::take(5)->get() as $u) {
        $out .= "- Name: " . $u->name . " | Serial: " . $u->serial_number . "\n";
    }
}

file_put_contents('debug_login_output.txt', $out);
echo $out;
