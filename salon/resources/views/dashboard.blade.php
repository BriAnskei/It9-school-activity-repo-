@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:56px;height:56px;background:#fce4ec;">
                    <i class="bi bi-scissors fs-4" style="color:#c2185b;"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $totalServices }}</div>
                    <div class="text-muted small">Total Services</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:56px;height:56px;background:#e3f2fd;">
                    <i class="bi bi-calendar-check fs-4 text-primary"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $totalAppointments }}</div>
                    <div class="text-muted small">Total Appointments</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:56px;height:56px;background:#e8f5e9;">
                    <i class="bi bi-check-circle fs-4 text-success"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $paidPayments }}</div>
                    <div class="text-muted small">Paid</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:56px;height:56px;background:#fff3e0;">
                    <i class="bi bi-clock fs-4 text-warning"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $unpaidPayments }}</div>
                    <div class="text-muted small">Unpaid</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0"><i class="bi bi-calendar-check me-2" style="color:#c2185b;"></i>Recent Appointments</h6>
            </div>
            <div class="card-body">
                @if($recentAppointments->count())
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="text-muted small">
                            <tr>
                                <th>Customer</th><th>Service</th><th>Date & Time</th><th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentAppointments as $appt)
                            <tr>
                                <td class="fw-semibold">{{ $appt->customer_name }}</td>
                                <td>{{ $appt->service->name ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}
                                    <span class="text-muted">{{ $appt->appointment_time }}</span>
                                </td>
                                <td>
                                    @if($appt->payment && $appt->payment->status === 'paid')
                                        <span class="badge bg-success-subtle text-success">Paid</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning">Unpaid</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <p class="text-muted text-center my-3">No appointments yet.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0"><i class="bi bi-scissors me-2" style="color:#c2185b;"></i>Services Overview</h6>
            </div>
            <div class="card-body">
                @foreach($services as $service)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <div class="fw-semibold small">{{ $service->name }}</div>
                        <div class="text-muted" style="font-size:0.8rem;">{{ $service->duration }}</div>
                    </div>
                    <span class="fw-bold" style="color:#c2185b;">₱{{ number_format($service->price, 2) }}</span>
                </div>
                @endforeach
                @if($services->isEmpty())
                    <p class="text-muted text-center my-3">No services yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
