@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Appointment Details</h5>
        <small class="text-muted">Booking #{{ $appointment->id }}</small>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom pt-4 pb-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-person-circle me-2" style="color:#c2185b;"></i>Customer Information</h6>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted">Name</dt>
                    <dd class="col-7 fw-semibold">{{ $appointment->customer_name }}</dd>

                    <dt class="col-5 text-muted">Contact</dt>
                    <dd class="col-7">{{ $appointment->customer_contact }}</dd>

                    <dt class="col-5 text-muted">Notes</dt>
                    <dd class="col-7 text-muted">{{ $appointment->notes ?? '—' }}</dd>

                    <dt class="col-5 text-muted">Booked On</dt>
                    <dd class="col-7">{{ $appointment->created_at->format('M d, Y h:i A') }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom pt-4 pb-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-scissors me-2" style="color:#c2185b;"></i>Service & Schedule</h6>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted">Service</dt>
                    <dd class="col-7 fw-semibold">{{ $appointment->service->name ?? '—' }}</dd>

                    <dt class="col-5 text-muted">Duration</dt>
                    <dd class="col-7">{{ $appointment->service->duration ?? '—' }}</dd>

                    <dt class="col-5 text-muted">Price</dt>
                    <dd class="col-7 fw-bold fs-5" style="color:#c2185b;">
                        ₱{{ number_format($appointment->service->price ?? 0, 2) }}
                    </dd>

                    <dt class="col-5 text-muted">Date</dt>
                    <dd class="col-7">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
                    </dd>

                    <dt class="col-5 text-muted">Time</dt>
                    <dd class="col-7">
                        <i class="bi bi-clock me-1"></i>
                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                    </dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom pt-4 pb-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-credit-card me-2" style="color:#c2185b;"></i>Payment Status</h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    @if($appointment->payment)
                        @if($appointment->payment->status === 'paid')
                            <span class="badge bg-success fs-6 px-3 py-2">
                                <i class="bi bi-check-circle me-1"></i> PAID
                            </span>
                            <div class="text-muted small mt-1">
                                Paid on {{ $appointment->payment->updated_at->format('M d, Y h:i A') }}
                                — Method: {{ ucfirst($appointment->payment->payment_method ?? 'N/A') }}
                            </div>
                        @else
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                <i class="bi bi-hourglass me-1"></i> UNPAID
                            </span>
                        @endif
                    @else
                        <span class="badge bg-secondary fs-6 px-3 py-2">
                            <i class="bi bi-dash-circle me-1"></i> No Payment Record
                        </span>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    @if(!$appointment->payment || $appointment->payment->status !== 'paid')
                        <a href="{{ route('payments.create', ['appointment_id' => $appointment->id]) }}"
                           class="btn btn-success">
                            <i class="bi bi-credit-card me-1"></i> Process Payment
                        </a>
                    @endif
                    <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                    <form action="{{ route('appointments.destroy', $appointment) }}"
                          method="POST"
                          onsubmit="return confirm('Delete this appointment?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
