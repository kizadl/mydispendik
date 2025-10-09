<?php
define('URL_SALT', 7042014); // Bebas, tapi tetap konsisten

function base62_encode($num) {
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $base = strlen($chars);
    $encoded = '';
    while ($num > 0) {
        $encoded = $chars[$num % $base] . $encoded;
        $num = floor($num / $base);
    }
    return $encoded;
}

function base62_decode($str) {
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $base = strlen($chars);
    $num = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        $num = $num * $base + strpos($chars, $str[$i]);
    }
    return $num;
}

// Encode ID dokumen
function encode_doc_id($id) {
    return base62_encode($id + URL_SALT);
}

// Decode dari URL
function decode_doc_id($encoded) {
    return base62_decode($encoded) - URL_SALT;
}
?>
