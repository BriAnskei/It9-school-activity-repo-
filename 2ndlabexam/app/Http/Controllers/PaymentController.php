<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order.rice')->get();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $orders = Order::whereDoesntHave('payment')->where('status', '!=', 'cancelled')->get();
        return view('payments.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|in:cash,card,online',
        ]);

        $order = Order::findOrFail($request->order_id);

        $payment = Payment::create([
            'order_id' => $request->order_id,
            'amount' => $order->total_price,
            'payment_method' => $request->payment_method,
            'status' => 'paid',
        ]);

        // Update order status
        $order->update(['status' => 'completed']);

        return redirect()->route('payments.index')->with('success', 'Payment processed successfully!');
    }

    public function show(string $id)
    {
        $payment = Payment::with('order.rice', 'order.user')->findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    public function edit(string $id)
    {
        $payment = Payment::findOrFail($id);
        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:paid,unpaid',
            'payment_method' => 'required|in:cash,card,online',
        ]);

        $payment = Payment::findOrFail($id);
        
        $payment->update([
            'payment_method' => $request->payment_method,
            'status' => $request->status,
        ]);

        // Update order status based on payment status
        $order = $payment->order;
        if ($request->status === 'paid') {
            $order->update(['status' => 'completed']);
        } else {
            $order->update(['status' => 'pending']);
        }

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully!');
    }

    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);
        
        // Restore order status
        $order = $payment->order;
        $order->update(['status' => 'pending']);
        
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully!');
    }
}