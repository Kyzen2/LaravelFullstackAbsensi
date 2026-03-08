<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use App\Models\Guru;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$guru = Guru::first();
if ($guru) {
    echo "GURU_ID:" . $guru->id . "\n";
    echo "GURU_NAME:" . $guru->nama_guru . "\n";
} else {
    echo "NO_GURU_FOUND\n";
}
