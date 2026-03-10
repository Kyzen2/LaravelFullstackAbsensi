<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Http;

$targetClass = "XII PPLG-RPL 2";
echo "Fetching API for class: $targetClass\n";

$response = Http::get('https://zieapi.zielabs.id/api/getsiswa', ['tahun' => '2025']);
if (!$response->successful()) {
    echo "API Request failed.\n";
    exit;
}

$data = $response->json()['data'];
$filtered = array_filter($data, function($item) use ($targetClass) {
    return trim($item['nama_rombel'] ?? '') === $targetClass;
});

echo "Total students in $targetClass: " . count($filtered) . "\n";
foreach ($filtered as $s) {
    echo "- NAME: {$s['nama']} | NISN: {$s['nisn']} | CLASS: {$s['nama_rombel']}\n";
}
