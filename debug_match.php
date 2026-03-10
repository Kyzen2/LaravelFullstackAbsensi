<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Http;

$targetClass = "XII PPLG-RPL 2";
$response = Http::get('https://zieapi.zielabs.id/api/getsiswa', ['tahun' => '2025']);
if ($response->successful()) {
    $data = $response->json()['data'];
    $matches = array_filter($data, function ($item) use ($targetClass) {
        $rombel = trim($item['nama_rombel'] ?? '');
        return $rombel === $targetClass || strtoupper($rombel) === strtoupper($targetClass);
    });
    
    echo "Total data: " . count($data) . "\n";
    echo "Found " . count($matches) . " matches for '$targetClass'\n";
    if (count($matches) > 0) {
        echo "First match: " . json_encode(array_values($matches)[0]) . "\n";
    } else {
        echo "No match found. Sample class from data: " . ($data[0]['nama_rombel'] ?? 'N/A') . "\n";
    }
} else {
    echo "API Failed: " . $response->status();
}
