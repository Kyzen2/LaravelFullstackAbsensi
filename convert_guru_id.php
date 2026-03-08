<?php
$content = file_get_contents('guru_id.txt');
$utf8_content = mb_convert_encoding($content, 'UTF-8', 'UTF-16LE');
file_put_contents('guru_id_utf8.txt', $utf8_content);
echo "CONVERTED.";
