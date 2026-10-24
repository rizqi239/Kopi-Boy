<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Pastikan direktori storage yang dibutuhkan di /tmp dibuat secara dinamis untuk Vercel Serverless
$storagePath = '/tmp/storage';
$subDirs = [
    '/framework/cache/data',
    '/framework/sessions',
    '/framework/views',
    '/logs',
    '/app/public',
    '/app/public/menus',
];

foreach ($subDirs as $dir) {
    $fullDir = $storagePath . $dir;
    if (!is_dir($fullDir)) {
        @mkdir($fullDir, 0755, true);
    }
}

// Register Composer Autoloader
require __DIR__.'/../vendor/autoload.php';

// Support SQLite fallback if DB_CONNECTION is sqlite
$dbConn = getenv('DB_CONNECTION') ?: ($_ENV['DB_CONNECTION'] ?? 'pgsql');
if ($dbConn === 'sqlite' && !file_exists('/tmp/database.sqlite')) {
    @touch('/tmp/database.sqlite');
}

// Maintenance mode check
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Bootstrap Laravel
/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->useStoragePath($storagePath);

// Jalankan migrasi database jika belum dijalankan pada instance ini
if (!file_exists('/tmp/migrated.lock')) {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        @touch('/tmp/migrated.lock');
    } catch (\Throwable $e) {
        error_log("Auto-migrate note: " . $e->getMessage());
    }
}

try {
    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    error_log("UNCAUGHT EXCEPTION: " . $e->getMessage() . "\n" . $e->getTraceAsString());
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    echo "Application Error: " . $e->getMessage() . "\n";
    echo "In " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();
}
