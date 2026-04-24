@extends('layouts.app')

@section('title', 'Record Payment')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Record Payment</h5>
        <small class="text-muted">Process payment for an appointment</small>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('payments.store') }}" method="POST" id="paymentForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Appointment <span class="text-danger">*</span></label>
                        <select name="appointment_id"
                                id="appointmentSelect"
                                class="form-select @error('appointment_id') is-invalid @enderror"
                                onchange="fillAppointmentDetails(this)">
                            <option value="">-- Select Appointment --</option>
                            @foreach($appointments as $appt)
                                <option value="{{ $appt->id }}"
                                        data-name="{{ $appt->customer_name }}"
                                        data-contact="{{ $appt->customer_contact }}"
                                        data-service="{{ $appt->service->name ?? '' }}"
                                        data-price="{{ $appt->service->price ?? 0 }}"
                                        data-date="{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}"
                                        data-time="{{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}"
                                        {{ (isset($selectedAppointment) && $selectedAppointment->id == $appt->id) ? 'selected' : '' }}>
                                    #{{ $appt->id }} — {{ $appt->customer_name }} ({{ $appt->service->name ?? 'N/A' }}) — {{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}
                                </option>
                            @endforeach
                        </select>
                        @error('appointment_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Amount (₱) <span class="text-danger">*</span></label>
                        <input type="number"
                               name="amount"
                               id="amountInput"
                               step="0.01"
                               min="0"
                               class="form-control @error('amount') is-invalid @enderror"
                               value="{{ old('amount') }}"
                               placeholder="0.00">
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
                                       {{ old('payment_method', 'cash') === $method ? 'checked' : '' }}>
                                <label class="form-check-label d-block" for="method_{{ $method }}" style="cursor:pointer;">
                                    <i class="bi {{ $icon }} d-block fs-4 mb-1"></i>
                                    {{ ucfirst($method) }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @error('payment_method')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="paid"   {{ old('status', 'paid') === 'paid'   ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ old('status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Remarks <span class="text-muted small fw-normal">(optional)</span></label>
                        <textarea name="remarks"
                                  class="form-control"
                                  rows="2"
                                  placeholder="Any notes about this payment...">{{ old('remarks') }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Save Payment
                        </button>
                        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Appointment Summary --}}
    <div class="col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-receipt me-2" style="color:#c2185b;"></i>Appointment Details
                </h6>
            </div>
            <div class="card-body">
                <div id="noApptMsg" class="text-center text-muted py-3 small">
                    <i class="bi bi-calendar3 fs-2 d-block mb-2 opacity-25"></i>
                    Select an appointment to preview details
                </div>
                <div id="apptDetails" class="d-none">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted small">Customer</dt>
                        <dd class="col-7 fw-semibold" id="detName">—</dd>

                        <dt class="col-5 text-muted small">Contact</dt>
                        <dd class="col-7 small" id="detContact">—</dd>

                        <dt class="col-5 text-muted small">Service</dt>
                        <dd class="col-7" id="detService">—</dd>

                        <dt class="col-5 text-muted small">Date</dt>
                        <dd class="col-7" id="detDate">—</dd>

                        <dt class="col-5 text-muted small">Time</dt>
                        <dd class="col-7" id="detTime">—</dd>

                        <dt class="col-5 text-muted small">Service Price</dt>
                        <dd class="col-7 fw-bold fs-5" style="color:#c2185b;" id="detPrice">—</dd>
                    </dl>
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

@section('scripts')
<script>
function fillAppointmentDetails(select) {
    const opt = select.options[select.selectedIndex];
    if (!opt.value) {
        document.getElementById('noApptMsg').classList.remove('d-none');
        document.getElementById('apptDetails').classList.add('d-none');
        return;
    }
    document.getElementById('noApptMsg').classList.add('d-none');
    document.getElementById('apptDetails').classList.remove('d-none');
    document.getElementById('detName').textContent    = opt.dataset.name;
    document.getElementById('detContact').textContent = opt.dataset.contact;
    document.getElementById('detService').textContent = opt.dataset.service;
    document.getElementById('detDate').textContent    = opt.dataset.date;
    document.getElementById('detTime').textContent    = opt.dataset.time;
    document.getElementById('detPrice').textContent   = '₱' + parseFloat(opt.dataset.price).toLocaleString('en-PH', {minimumFractionDigits: 2});
    // Auto-fill amount with service price
    document.getElementById('amountInput').value      = parseFloat(opt.dataset.price).toFixed(2);
}

// Trigger on load if pre-selected appointment
window.addEventListener('DOMContentLoaded', () => {
    const sel = document.getElementById('appointmentSelect');
    if (sel.value) fillAppointmentDetails(sel);
});
</script>
@endsection
