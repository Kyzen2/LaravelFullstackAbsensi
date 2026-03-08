<?php
ini_set('memory_limit', '1G');
set_time_limit(300);

$targetClass = "XII PPLG-RPL 2";
$url = "https://zieapi.zielabs.id/api/getsiswa?tahun=2025";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
curl_setopt($ch, CURLOPT_TIMEOUT, 240);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    file_put_contents('import_error.log', "CURL ERROR: " . curl_error($ch));
    exit;
}
curl_close($ch);

$data = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    file_put_contents('import_error.log', "JSON ERROR: " . json_last_error_msg());
    exit;
}

$filtered = [];
foreach ($data as $item) {
    if (isset($item['nama_rombel']) && trim($item['nama_rombel']) === $targetClass) {
        $filtered[] = $item;
    }
}

file_put_contents('XII_PPLG_RPL_2.json', json_encode($filtered, JSON_PRETTY_PRINT));
echo "SAVED " . count($filtered) . " STUDENTS";
