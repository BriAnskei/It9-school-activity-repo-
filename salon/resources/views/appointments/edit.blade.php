@extends('layouts.app')

@section('title', 'Edit Appointment')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Edit Appointment</h5>
        <small class="text-muted">Booking #{{ $appointment->id }} — {{ $appointment->customer_name }}</small>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('appointments.update', $appointment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h6 class="fw-bold mb-3 text-muted text-uppercase" style="font-size:0.75rem;letter-spacing:1px;">
                        <i class="bi bi-person me-1"></i> Customer Details
                    </h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Customer Name <span class="text-danger">*</span></label>
                        <input type="text"
                               name="customer_name"
                               class="form-control @error('customer_name') is-invalid @enderror"
                               value="{{ old('customer_name', $appointment->customer_name) }}">
                        @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Contact Number / Email <span class="text-danger">*</span></label>
                        <input type="text"
                               name="customer_contact"
                               class="form-control @error('customer_contact') is-invalid @enderror"
                               value="{{ old('customer_contact', $appointment->customer_contact) }}">
                        @error('customer_contact') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr class="my-3">

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
                                        {{ old('service_id', $appointment->service_id) == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} — ₱{{ number_format($service->price, 2) }} ({{ $service->duration }})
                                </option>
                            @endforeach
                        </select>
                        @error('service_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                            <input type="date"
                                   name="appointment_date"
                                   class="form-control @error('appointment_date') is-invalid @enderror"
                                   value="{{ old('appointment_date', $appointment->appointment_date) }}">
                            @error('appointment_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Time <span class="text-danger">*</span></label>
                            <input type="time"
                                   name="appointment_time"
                                   class="form-control @error('appointment_time') is-invalid @enderror"
                                   value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}">
                            @error('appointment_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Notes</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes', $appointment->notes) }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Update Appointment
                        </button>
                        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0"><i class="bi bi-receipt me-2" style="color:#c2185b;"></i>Booking Summary</h6>
            </div>
            <div class="card-body">
                <div id="noServiceMsg" class="text-center text-muted py-3 small d-none">
                    Select a service to see summary
                </div>
                <div id="summaryDetails">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted small">Service</dt>
                        <dd class="col-7 fw-semibold" id="sumService">{{ $appointment->service->name ?? '—' }}</dd>
                        <dt class="col-5 text-muted small">Duration</dt>
                        <dd class="col-7" id="sumDuration">{{ $appointment->service->duration ?? '—' }}</dd>
                        <dt class="col-5 text-muted small">Price</dt>
                        <dd class="col-7 fw-bold fs-5" style="color:#c2185b;" id="sumPrice">
                            ₱{{ number_format($appointment->service->price ?? 0, 2) }}
                        </dd>
                    </dl>
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
</script>
@endsection
