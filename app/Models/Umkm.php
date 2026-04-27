<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $fillable = [
        'user_id',
        'nama_umkm',
        'alamat',
        'no_hp',
        'deskripsi',
        'logo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function keuangans()
    {
        return $this->hasMany(Keuangan::class);
    }
}
