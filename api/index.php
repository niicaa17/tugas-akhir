<?php
// Create folder for compiled views (Vercel filesystem is read-only except /tmp)
$viewPath = '/tmp/storage/framework/views';
if (!is_dir($viewPath)) {
    mkdir($viewPath, 0755, true);
}

// Forward Vercel requests to Laravel's public/index.php
require __DIR__ . '/../public/index.php';
