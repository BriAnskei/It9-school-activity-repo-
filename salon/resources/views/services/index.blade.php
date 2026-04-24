@extends('layouts.app')

@section('title', 'Services')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Salon Services</h5>
        <small class="text-muted">Manage all your salon/nail services</small>
    </div>
    <a href="{{ route('services.create') }}" class="btn btn-sm btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Service
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#fce4ec;">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Service Name</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Description</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr>
                        <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $service->name }}</td>
                        <td class="fw-bold" style="color:#c2185b;">₱{{ number_format($service->price, 2) }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-clock me-1"></i>{{ $service->duration }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ Str::limit($service->description, 60) ?? '—' }}</td>
                        <td class="text-center">
                            <a href="{{ route('services.edit', $service) }}"
                               class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('services.destroy', $service) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this service?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-scissors fs-2 d-block mb-2"></i>
                            No services found. <a href="{{ route('services.create') }}">Add one now</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($services->hasPages())
    <div class="card-footer bg-white border-0">
        {{ $services->links() }}
    </div>
    @endif
</div>
@endsection
