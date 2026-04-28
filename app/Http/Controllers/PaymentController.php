<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $orderId = $request->query('order');

        abort_unless($orderId, 404);

        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('payments.create', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'metode' => 'required|in:cod,transfer,debit,virtual_account',
        ]);

        $order = Order::where('id', $data['order_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $metode = in_array($data['metode'], ['debit', 'virtual_account'], true)
            ? 'transfer'
            : $data['metode'];

        if ($order->status !== 'pending') {
            return back()->withErrors(['order_id' => 'Pesanan ini tidak dapat dibayar ulang.']);
        }

        Payment::create([
            'order_id' => $order->id,
            'metode' => $metode,
            'jumlah' => $order->total_harga,
            'status' => 'pending',
        ]);
        $order->update(['status' => 'dibayar']);

        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil dikirim');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
