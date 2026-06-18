<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'harga',
        'rating',
        'review_komentar',
        'review_foto',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'qty' => 'integer',
            'harga' => 'integer',
            'rating' => 'integer',
            'reviewed_at' => 'datetime',
        ];
    }

    public function isReviewed(): bool
    {
        return ! is_null($this->reviewed_at);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
