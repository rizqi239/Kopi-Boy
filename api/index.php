<?php

// Matikan output error/deprecated langsung ke browser agar tidak merusak HTTP response headers
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

// Pastikan direktori storage yang dibutuhkan di /tmp dibuat secara dinamis untuk Vercel Serverless
$storagePath = '/tmp/storage';
$subDirs = [
    '/framework/cache/data',
    '/framework/sessions',
    '/framework/views',
    '/logs',
    '/app/public'
];

foreach ($subDirs as $dir) {
    $fullDir = $storagePath . $dir;
    if (!is_dir($fullDir)) {
        mkdir($fullDir, 0755, true);
    }
}

// Forward request ke public/index.php Laravel
require __DIR__ . '/../public/index.php';
