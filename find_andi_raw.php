<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$students = DB::table('siswa')->where('nama_siswa', 'like', '%Andi%')->get();
$users = DB::table('users')->where('name', 'like', '%Andi%')->get();

$result = [
    'students' => $students,
    'users' => $users
];

file_put_contents('raw_andi_search.json', json_encode($result, JSON_PRETTY_PRINT));
echo "Done.";
