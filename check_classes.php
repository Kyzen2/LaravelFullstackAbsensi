<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Http;

$response = Http::get('https://zieapi.zielabs.id/api/getsiswa', ['tahun' => '2025']);
if ($response->successful()) {
    $data = $response->json()['data'];
    $classes = array_unique(array_column($data, 'nama_rombel'));
    asort($classes);
    file_put_contents('api_classes.txt', implode("\n", $classes));
    echo "Saved " . count($classes) . " classes.";
} else {
    echo "API Failed: " . $response->status();
}
