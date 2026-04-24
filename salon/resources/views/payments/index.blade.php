@extends('layouts.app')

@section('title', 'Payments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Payment History</h5>
        <small class="text-muted">All payment transactions</small>
    </div>
    <a href="{{ route('payments.create') }}" class="btn btn-sm btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Record Payment
    </a>
</div>

{{-- Summary Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:52px;height:52px;background:#e8f5e9;">
                    <i class="bi bi-cash-stack fs-4 text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Collected</div>
                    <div class="fw-bold fs-5 text-success">₱{{ number_format($totalCollected, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:52px;height:52px;background:#fff3e0;">
                    <i class="bi bi-hourglass-split fs-4 text-warning"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Unpaid</div>
                    <div class="fw-bold fs-5 text-warning">₱{{ number_format($totalUnpaid, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:52px;height:52px;background:#fce4ec;">
                    <i class="bi bi-credit-card fs-4" style="color:#c2185b;"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Transactions</div>
                    <div class="fw-bold fs-5" style="color:#c2185b;">{{ $payments->total() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Payments Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#fce4ec;">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Customer</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                        <td class="fw-semibold">
                            {{ $payment->appointment->customer_name ?? '—' }}
                        </td>
                        <td class="text-muted small">
                            {{ $payment->appointment->service->name ?? '—' }}
                        </td>
                        <td class="small">
                            {{ \Carbon\Carbon::parse($payment->appointment->appointment_date ?? now())->format('M d, Y') }}
                        </td>
                        <td class="fw-bold" style="color:#c2185b;">
                            ₱{{ number_format($payment->amount, 2) }}
                        </td>
                        <td>
                            @php
                                $methodIcons = ['cash' => 'bi-cash', 'gcash' => 'bi-phone', 'card' => 'bi-credit-card'];
                                $icon = $methodIcons[$payment->payment_method] ?? 'bi-question';
                            @endphp
                            <span class="badge bg-light text-dark border">
                                <i class="bi {{ $icon }} me-1"></i>
                                {{ ucfirst($payment->payment_method) }}
                            </span>
                        </td>
                        <td>
                            @if($payment->status === 'paid')
                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-check-circle me-1"></i>Paid
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                    <i class="bi bi-hourglass me-1"></i>Unpaid
                                </span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ Str::limit($payment->remarks, 30) ?? '—' }}</td>
                        <td class="text-center">
                            {{-- Quick toggle status --}}
                            @if($payment->status === 'unpaid')
                                <form action="{{ route('payments.markPaid', $payment) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success me-1" title="Mark as Paid">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('payments.markUnpaid', $payment) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-warning me-1" title="Mark as Unpaid">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('payments.edit', $payment) }}"
                               class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('payments.destroy', $payment) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this payment record?')">
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
                            <i class="bi bi-credit-card fs-2 d-block mb-2"></i>
                            No payment records yet. <a href="{{ route('payments.create') }}">Record one now</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($payments->hasPages())
    <div class="card-footer bg-white border-0">
        {{ $payments->links() }}
    </div>
    @endif
</div>
@endsection
