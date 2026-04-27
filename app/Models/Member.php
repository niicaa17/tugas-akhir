<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'umkm_id',
        'nama_karyawan',
        'alamat_karyawan',
        'telepon_karyawan',
        'jabatan'
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }
}
