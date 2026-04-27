<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $table = 'keuangan';

    protected $fillable = [
        'product_id',
        'umkm_id',
        'jenis',
        'jumlah',
        'keterangan',
        'tanggal',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'tanggal' => 'date',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
