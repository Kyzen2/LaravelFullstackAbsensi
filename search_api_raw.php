<?php
$raw = file_get_contents('https://zieapi.zielabs.id/api/getsiswa?tahun=2025');
$json = json_decode($raw, true);
$data = $json['data'] ?? [];

$found = [];
foreach ($data as $item) {
    if (isset($item['nama']) && (stripos($item['nama'], 'Andi') !== false || ($item['nisn'] ?? '') == '223344')) {
        $found[] = $item;
    }
}

file_put_contents('api_raw_andi.json', json_encode($found, JSON_PRETTY_PRINT));
echo "Matches found: " . count($found);
