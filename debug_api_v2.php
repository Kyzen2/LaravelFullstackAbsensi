<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use Illuminate\Support\Facades\Http;

$response = Http::timeout(120)->get('https://zieapi.zielabs.id/api/getsiswa', ['tahun' => '2025']);

$json = $response->json();
$out = "API DEBUG:\n";
$out .= "STATUS: " . ($json['status'] ?? 'N/A') . "\n";
$out .= "COUNT: " . (isset($json['data']) ? count($json['data']) : 'N/A') . "\n\n";

if (isset($json['data'])) {
    foreach (array_slice($json['data'], 0, 20) as $i => $item) {
        $out .= "[$i] Rombel: " . ($item['nama_rombel'] ?? 'N/A') . " | Nama: " . ($item['nama'] ?? 'N/A') . "\n";
    }
}

file_put_contents('api_debug_v2.txt', $out);
