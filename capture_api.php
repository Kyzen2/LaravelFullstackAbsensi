<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use Illuminate\Support\Facades\Http;

$response = Http::timeout(120)->withHeaders([
    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
])->get('https://zieapi.zielabs.id/api/getsiswa', ['tahun' => '2025']);

file_put_contents('raw_api_response.json', $response->body());
echo "LENGTH: " . strlen($response->body());
