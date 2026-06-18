<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order, OrderDetail $detail)
    {
        // Pastikan pesanan milik user yang login
        abort_unless($order->user_id === Auth::id(), 403);

        // Detail harus bagian dari order ini
        abort_unless($detail->order_id === $order->id, 404);

        // Review hanya untuk pesanan yang sudah selesai
        abort_unless($order->status === 'selesai', 403, 'Pesanan belum selesai');

        // Tidak boleh review dua kali
        abort_if($detail->isReviewed(), 409, 'Produk ini sudah kamu ulas');

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_komentar' => 'nullable|string|max:1000',
            'review_foto' => 'nullable|image|max:2048',
        ]);

        $detail->rating = $data['rating'];
        $detail->review_komentar = $data['review_komentar'] ?? null;

        if ($request->hasFile('review_foto')) {
            $detail->review_foto = $request->file('review_foto')->store('reviews', 'public');
        }

        $detail->reviewed_at = now();
        $detail->save();

        return back()->with('success', 'Terima kasih! Ulasanmu sudah tersimpan.');
    }
}
