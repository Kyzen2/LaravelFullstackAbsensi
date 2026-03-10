<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Http;

$targetNisn = "223344";
$targetName = "Andi Pratama";

$response = Http::get('https://zieapi.zielabs.id/api/getsiswa', ['tahun' => '2025']);
$data = $response->json()['data'];

$found = [];
foreach ($data as $item) {
    if (($item['nisn'] ?? '') == $targetNisn || stripos($item['nama'] ?? '', $targetName) !== false) {
        $found[] = $item;
    }
}

file_put_contents('api_andi_check.json', json_encode($found, JSON_PRETTY_PRINT));
echo "Found " . count($found) . " matches.";
