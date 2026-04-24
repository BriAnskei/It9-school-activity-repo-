@extends('layouts.app')

@section('title', 'Edit Payment')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Edit Payment</h5>
        <small class="text-muted">Payment #{{ $payment->id }} — {{ $payment->appointment->customer_name ?? '' }}</small>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('payments.update', $payment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Read-only appointment info --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Appointment</label>
                        <input type="text" class="form-control bg-light" readonly
                               value="#{{ $payment->appointment->id }} — {{ $payment->appointment->customer_name }} ({{ $payment->appointment->service->name ?? 'N/A' }}) — {{ \Carbon\Carbon::parse($payment->appointment->appointment_date)->format('M d, Y') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Amount (₱) <span class="text-danger">*</span></label>
                        <input type="number"
                               name="amount"
                               step="0.01"
                               min="0"
                               class="form-control @error('amount') is-invalid @enderror"
                               value="{{ old('amount', $payment->amount) }}">
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Payment Method <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            @foreach(['cash' => 'bi-cash', 'gcash' => 'bi-phone', 'card' => 'bi-credit-card'] as $method => $icon)
                            <div class="form-check border rounded px-3 py-2 flex-fill text-center method-option"
                                 style="cursor:pointer;">
                                <input class="form-check-input d-none"
                                       type="radio"
                                       name="payment_method"
                                       id="method_{{ $method }}"
                                       value="{{ $method }}"
                                       {{ old('payment_method', $payment->payment_method) === $method ? 'checked' : '' }}>
                                <label class="form-check-label d-block" for="method_{{ $method }}" style="cursor:pointer;">
                                    <i class="bi {{ $icon }} d-block fs-4 mb-1"></i>
                                    {{ ucfirst($method) }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="paid"   {{ old('status', $payment->status) === 'paid'   ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ old('status', $payment->status) === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="2">{{ old('remarks', $payment->remarks) }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Update Payment
                        </button>
                        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Current Payment Info --}}
    <div class="col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-info-circle me-2" style="color:#c2185b;"></i>Current Record
                </h6>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted small">Customer</dt>
                    <dd class="col-7 fw-semibold">{{ $payment->appointment->customer_name ?? '—' }}</dd>

                    <dt class="col-5 text-muted small">Service</dt>
                    <dd class="col-7">{{ $payment->appointment->service->name ?? '—' }}</dd>

                    <dt class="col-5 text-muted small">Date</dt>
                    <dd class="col-7">{{ \Carbon\Carbon::parse($payment->appointment->appointment_date)->format('M d, Y') }}</dd>

                    <dt class="col-5 text-muted small">Amount</dt>
                    <dd class="col-7 fw-bold" style="color:#c2185b;">₱{{ number_format($payment->amount, 2) }}</dd>

                    <dt class="col-5 text-muted small">Method</dt>
                    <dd class="col-7">{{ ucfirst($payment->payment_method) }}</dd>

                    <dt class="col-5 text-muted small">Status</dt>
                    <dd class="col-7">
                        @if($payment->status === 'paid')
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Paid</span>
                        @else
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Unpaid</span>
                        @endif
                    </dd>

                    <dt class="col-5 text-muted small">Last Updated</dt>
                    <dd class="col-7 small">{{ $payment->updated_at->format('M d, Y h:i A') }}</dd>
                </dl>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-body p-3">
                <p class="text-muted small mb-2 fw-semibold">Quick Actions</p>
                <div class="d-flex gap-2">
                    @if($payment->status === 'unpaid')
                        <form action="{{ route('payments.markPaid', $payment) }}" method="POST" class="flex-fill">
                            @csrf @method('PATCH')
                            <button class="btn btn-success w-100 btn-sm">
                                <i class="bi bi-check-circle me-1"></i> Mark as Paid
                            </button>
                        </form>
                    @else
                        <form action="{{ route('payments.markUnpaid', $payment) }}" method="POST" class="flex-fill">
                            @csrf @method('PATCH')
                            <button class="btn btn-outline-warning w-100 btn-sm">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Mark as Unpaid
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.method-option { transition: all .15s; }
.method-option:has(input:checked) {
    background: #fce4ec;
    border-color: #c2185b !important;
    color: #c2185b;
}
.method-option:hover { background: #f8f9fa; }
</style>
@endsection
