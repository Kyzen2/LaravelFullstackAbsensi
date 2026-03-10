<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Siswa;
use App\Models\User;

$data = [
    'students' => Siswa::where('nama_siswa', 'like', '%Andi%')->get()->toArray(),
    'users' => User::where('name', 'like', '%Andi%')->get()->toArray(),
];

file_put_contents('clean_search_result.json', json_encode($data, JSON_PRETTY_PRINT));
echo "Saved " . (count($data['students']) + count($data['users'])) . " items.";
