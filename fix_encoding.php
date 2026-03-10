<?php
$files = ['api_search_result.txt', 'student_list.txt', 'find_andi_result.txt'];
foreach ($files as $f) {
    if (file_exists($f)) {
        $content = file_get_contents($f);
        // Detect UTF-16LE or standard
        if (strpos($content, "\xFF\xFE") === 0 || strpos($content, "\x00") !== false) {
             $content = mb_convert_encoding($content, 'UTF-8', 'UTF-16LE');
        }
        file_put_contents($f . '_utf8.txt', $content);
    }
}
echo "Done.";
