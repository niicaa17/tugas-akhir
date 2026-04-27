<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$product = \App\Models\Product::create([
    'umkm_id' => 2,
    'category_id' => 1,
    'nama_produk' => 'WEDJANGKU & KITSAJU',
    'deskripsi' => 'Produk kolaborasi WEDJANGKU & KITSAJU',
    'harga' => 30000,
    'stok' => 20
]);

echo "Produk berhasil ditambahkan dengan ID: " . $product->id . "\n";

$products = \App\Models\Product::with('umkm')->orderBy('id')->get();
foreach ($products as $p) {
    echo "- " . $p->id . ": " . $p->nama_produk . " (" . $p->umkm->nama_umkm . ")\n";
}
