<?php
ini_set('memory_limit', '512M');
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use Illuminate\Support\Facades\Http;

$response = Http::timeout(120)->get('https://zieapi.zielabs.id/api/getsiswa', ['tahun' => '2025']);

if (!$response->successful()) {
    file_put_contents('api_debug.txt', "FAILED TO FETCH API: " . $response->status());
    exit;
}

$data = $response->json();
$classes = [];
foreach ($data as $item) {
    if (isset($item['nama_rombel'])) {
        $classes[$item['nama_rombel']] = ($classes[$item['nama_rombel']] ?? 0) + 1;
    }
}

ksort($classes);

$out = "UNIQUE CLASSES IN API:\n\n";
foreach ($classes as $name => $count) {
    $out .= "$name ($count students)\n";
}

file_put_contents('api_classes.txt', $out);
file_put_contents('api_sample_raw.json', json_encode(array_slice($data, 0, 5), JSON_PRETTY_PRINT));
