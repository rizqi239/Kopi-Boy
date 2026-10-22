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

// Pastikan database sqlite di /tmp ada
$dbFile = '/tmp/database.sqlite';
$isNewDb = !file_exists($dbFile);
if ($isNewDb) {
    touch($dbFile);
}

// Bootstrap Laravel
define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Jika database sqlite baru dibuat di /tmp, jalankan migrasi otomatis
if ($isNewDb && env('DB_CONNECTION') === 'sqlite') {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    } catch (\Throwable $e) {
        // Abaikan error migrasi agar request utama tetap jalan
    }
}

$app->handleRequest(\Illuminate\Http\Request::capture());
