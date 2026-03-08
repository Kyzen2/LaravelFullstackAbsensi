<?php
$content = file_get_contents('final_import_v4_result.txt');
$utf8_content = mb_convert_encoding($content, 'UTF-8', 'UTF-16LE');
file_put_contents('final_import_v4_result_utf8.txt', $utf8_content);
echo "CONVERTED.";
