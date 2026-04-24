<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['appointment.service'])
                        ->latest()
                        ->paginate(10);

        $totalCollected = Payment::where('status', 'paid')->sum('amount');
        $totalUnpaid    = Payment::where('status', 'unpaid')->sum('amount');

        return view('payments.index', compact('payments', 'totalCollected', 'totalUnpaid'));
    }

    public function create(Request $request)
    {
        // Can be pre-filled from appointment show page
        $selectedAppointment = null;
        if ($request->has('appointment_id')) {
            $selectedAppointment = Appointment::with('service')
                                    ->findOrFail($request->appointment_id);
        }

        $appointments = Appointment::with('service')
                            ->doesntHave('payment')
                            ->orWhereHas('payment', fn($q) => $q->where('status', 'unpaid'))
                            ->get();

        return view('payments.create', compact('appointments', 'selectedAppointment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'amount'         => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,gcash,card',
            'status'         => 'required|in:paid,unpaid',
            'remarks'        => 'nullable|string',
        ]);

        // Update if payment record already exists, else create new
        Payment::updateOrCreate(
            ['appointment_id' => $request->appointment_id],
            $request->only(['amount', 'payment_method', 'status', 'remarks'])
        );

        return redirect()->route('payments.index')
                         ->with('success', 'Payment recorded successfully.');
    }

    public function edit(Payment $payment)
    {
        $payment->load('appointment.service');
        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'amount'         => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,gcash,card',
            'status'         => 'required|in:paid,unpaid',
            'remarks'        => 'nullable|string',
        ]);

        $payment->update($request->only(['amount', 'payment_method', 'status', 'remarks']));

        return redirect()->route('payments.index')
                         ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')
                         ->with('success', 'Payment record deleted.');
    }

    public function markPaid(Payment $payment)
    {
        $payment->update(['status' => 'paid']);
        return back()->with('success', 'Payment marked as Paid.');
    }

    public function markUnpaid(Payment $payment)
    {
        $payment->update(['status' => 'unpaid']);
        return back()->with('success', 'Payment marked as Unpaid.');
    }
}
