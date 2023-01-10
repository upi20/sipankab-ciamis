<?php
// ambil helper
require_once __DIR__ . '/../library/phpqrcode/qrlib.php';

function get($name): mixed
{
    return isset($_GET[$name]) ? $_GET[$name] : null;
}

$text = get('key');
$text = is_null($text) ? 'Key Not Found' : $text;
QRcode::png($text);
