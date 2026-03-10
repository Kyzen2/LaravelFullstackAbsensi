<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Http;

$targetName = "Andi Pratama";
$response = Http::get('https://zieapi.zielabs.id/api/getsiswa', ['tahun' => '2025']);

if ($response->successful()) {
    $data = $response->json()['data'];
    $found = array_filter($data, function($item) use ($targetName) {
        return stripos($item['nama'] ?? '', $targetName) !== false;
    });

    if (count($found) > 0) {
        echo "FOUND in API:\n";
        foreach ($found as $item) {
            echo "- Name: {$item['nama']}, NISN: {$item['nisn']}, Class: {$item['nama_rombel']}\n";
        }
    } else {
        echo "NOT FOUND in API.\n";
    }
} else {
    echo "API Failed.\n";
}
