<?php

/**
 * InfinityFree Hosting - index.php
 * 
 * File ini MENGGANTIKAN index.php bawaan Laravel di htdocs/.
 * Path disesuaikan agar mengarah ke folder app-files/ yang berisi
 * semua file Laravel (app/, bootstrap/, vendor/, dll).
 * 
 * CARA PAKAI:
 * 1. Upload semua file Laravel ke htdocs/app-files/
 * 2. Upload isi folder public/ (termasuk file ini) ke htdocs/
 * 3. Ganti htdocs/index.php dengan file ini
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/app-files/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/app-files/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/app-files/bootstrap/app.php';

$app->handleRequest(Request::capture());
