@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Appointments</h5>
        <small class="text-muted">All bookings and schedules</small>
    </div>
    <a href="{{ route('appointments.create') }}" class="btn btn-sm btn-primary">
        <i class="bi bi-plus-lg me-1"></i> New Booking
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#fce4ec;">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Price</th>
                        <th>Payment</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                    <tr>
                        <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $appt->customer_name }}</td>
                        <td class="text-muted small">{{ $appt->customer_contact }}</td>
                        <td>{{ $appt->service->name ?? '—' }}</td>
                        <td>
                            <i class="bi bi-calendar3 me-1 text-muted"></i>
                            {{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}
                        </td>
                        <td>
                            <i class="bi bi-clock me-1 text-muted"></i>
                            {{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}
                        </td>
                        <td class="fw-bold" style="color:#c2185b;">
                            ₱{{ number_format($appt->service->price ?? 0, 2) }}
                        </td>
                        <td>
                            @if($appt->payment && $appt->payment->status === 'paid')
                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-check-circle me-1"></i>Paid
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                    <i class="bi bi-hourglass me-1"></i>Unpaid
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('appointments.show', $appt) }}"
                               class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('appointments.edit', $appt) }}"
                               class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('appointments.destroy', $appt) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this appointment?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-5">
                            <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
                            No appointments yet. <a href="{{ route('appointments.create') }}">Book one now</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($appointments->hasPages())
    <div class="card-footer bg-white border-0">
        {{ $appointments->links() }}
    </div>
    @endif
</div>
@endsection
