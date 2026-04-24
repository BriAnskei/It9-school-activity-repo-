@extends('layouts.app')

@section('title', 'New Booking')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">New Appointment</h5>
        <small class="text-muted">Fill in the booking details below</small>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('appointments.store') }}" method="POST" id="bookingForm">
                    @csrf

                    {{-- Customer Details --}}
                    <h6 class="fw-bold mb-3 text-muted text-uppercase" style="font-size:0.75rem;letter-spacing:1px;">
                        <i class="bi bi-person me-1"></i> Customer Details
                    </h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Customer Name <span class="text-danger">*</span></label>
                        <input type="text"
                               name="customer_name"
                               class="form-control @error('customer_name') is-invalid @enderror"
                               value="{{ old('customer_name') }}"
                               placeholder="Full name">
                        @error('customer_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Contact Number / Email <span class="text-danger">*</span></label>
                        <input type="text"
                               name="customer_contact"
                               class="form-control @error('customer_contact') is-invalid @enderror"
                               value="{{ old('customer_contact') }}"
                               placeholder="e.g. 09xxxxxxxxx or email@example.com">
                        @error('customer_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-3">

                    {{-- Service & Schedule --}}
                    <h6 class="fw-bold mb-3 text-muted text-uppercase" style="font-size:0.75rem;letter-spacing:1px;">
                        <i class="bi bi-scissors me-1"></i> Service & Schedule
                    </h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Service <span class="text-danger">*</span></label>
                        <select name="service_id"
                                id="serviceSelect"
                                class="form-select @error('service_id') is-invalid @enderror"
                                onchange="updateServiceInfo(this)">
                            <option value="">-- Select a Service --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}"
                                        data-price="{{ $service->price }}"
                                        data-duration="{{ $service->duration }}"
                                        {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} — ₱{{ number_format($service->price, 2) }} ({{ $service->duration }})
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                            <input type="date"
                                   name="appointment_date"
                                   class="form-control @error('appointment_date') is-invalid @enderror"
                                   value="{{ old('appointment_date') }}"
                                   min="{{ date('Y-m-d') }}">
                            @error('appointment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Time <span class="text-danger">*</span></label>
                            <input type="time"
                                   name="appointment_time"
                                   class="form-control @error('appointment_time') is-invalid @enderror"
                                   value="{{ old('appointment_time') }}">
                            @error('appointment_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Notes <span class="text-muted small fw-normal">(optional)</span></label>
                        <textarea name="notes"
                                  class="form-control"
                                  rows="2"
                                  placeholder="Any special requests or notes...">{{ old('notes') }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-calendar-check me-1"></i> Book Appointment
                        </button>
                        <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Booking Summary --}}
    <div class="col-md-5">
        <div class="card border-0 shadow-sm" id="summaryCard">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0"><i class="bi bi-receipt me-2" style="color:#c2185b;"></i>Booking Summary</h6>
            </div>
            <div class="card-body">
                <div id="noServiceMsg" class="text-center text-muted py-3 small">
                    <i class="bi bi-scissors fs-2 d-block mb-2 opacity-25"></i>
                    Select a service to see summary
                </div>
                <div id="summaryDetails" class="d-none">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted small">Service</dt>
                        <dd class="col-7 fw-semibold" id="sumService">—</dd>
                        <dt class="col-5 text-muted small">Duration</dt>
                        <dd class="col-7" id="sumDuration">—</dd>
                        <dt class="col-5 text-muted small">Price</dt>
                        <dd class="col-7 fw-bold fs-5" style="color:#c2185b;" id="sumPrice">—</dd>
                    </dl>
                    <hr>
                    <div class="alert alert-info py-2 small mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Payment can be processed after booking is saved.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function updateServiceInfo(select) {
    const opt = select.options[select.selectedIndex];
    if (!opt.value) {
        document.getElementById('noServiceMsg').classList.remove('d-none');
        document.getElementById('summaryDetails').classList.add('d-none');
        return;
    }
    document.getElementById('noServiceMsg').classList.add('d-none');
    document.getElementById('summaryDetails').classList.remove('d-none');
    document.getElementById('sumService').textContent  = opt.text.split('—')[0].trim();
    document.getElementById('sumDuration').textContent = opt.dataset.duration;
    document.getElementById('sumPrice').textContent    = '₱' + parseFloat(opt.dataset.price).toLocaleString('en-PH', {minimumFractionDigits: 2});
}

// Trigger on page load if old value exists
window.addEventListener('DOMContentLoaded', () => {
    const sel = document.getElementById('serviceSelect');
    if (sel.value) updateServiceInfo(sel);
});
</script>
@endsection
