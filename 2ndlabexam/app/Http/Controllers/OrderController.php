<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Rice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['rice', 'user'])->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $rices = Rice::where('stock', '>', 0)->get();
        return view('orders.create', compact('rices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rice_id' => 'required|exists:rice,id',
            'quantity' => 'required|numeric|min:0.1',
        ]);

        $rice = Rice::findOrFail($request->rice_id);
        
        if ($rice->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Insufficient stock available.']);
        }

        $totalPrice = $rice->price_per_kg * $request->quantity;

        $order = Order::create([
            'user_id' => Auth::id(),
            'rice_id' => $request->rice_id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // Deduct stock
        $rice->decrement('stock', $request->quantity);

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    public function show(string $id)
    {
        $order = Order::with(['rice', 'user', 'payment'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function edit(string $id)
    {
        $order = Order::findOrFail($id);
        $rices = Rice::all();
        return view('orders.edit', compact('order', 'rices'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'rice_id' => 'required|exists:rice,id',
            'quantity' => 'required|numeric|min:0.1',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $rice = Rice::findOrFail($request->rice_id);
        
        $totalPrice = $rice->price_per_kg * $request->quantity;

        $order->update([
            'rice_id' => $request->rice_id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => $request->status,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }

    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        
        // Restore stock
        $rice = $order->rice;
        if ($rice) {
            $rice->increment('stock', $order->quantity);
        }
        
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }
}