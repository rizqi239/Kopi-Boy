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

// SQLite is only used when explicitly configured; production uses persistent Postgres.
if (env('DB_CONNECTION') === 'sqlite' && !file_exists('/tmp/database.sqlite')) {
    touch('/tmp/database.sqlite');
}

// Bootstrap Laravel
define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->useStoragePath($storagePath);

try {
    $app->handleRequest(\Illuminate\Http\Request::capture());
} catch (\Throwable $e) {
    error_log("UNCAUGHT EXCEPTION: " . $e->getMessage() . "\n" . $e->getTraceAsString());
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    echo "Application Error: " . $e->getMessage() . "\n";
    echo "In " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();
}
