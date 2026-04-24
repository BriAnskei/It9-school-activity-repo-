@extends('layouts.app')

@section('title', 'Edit Service')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('services.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Edit Service</h5>
        <small class="text-muted">Update details for <strong>{{ $service->name }}</strong></small>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('services.update', $service) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Service Name <span class="text-danger">*</span></label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $service->name) }}"
                               placeholder="e.g. Manicure, Pedicure, Gel Polish">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Price (₱) <span class="text-danger">*</span></label>
                            <input type="number"
                                   name="price"
                                   step="0.01"
                                   min="0"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $service->price) }}"
                                   placeholder="0.00">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Duration <span class="text-danger">*</span></label>
                            <select name="duration" class="form-select @error('duration') is-invalid @enderror">
                                <option value="">-- Select Duration --</option>
                                @foreach(['30 mins','45 mins','1 hour','1.5 hours','2 hours','2.5 hours','3 hours'] as $dur)
                                    <option value="{{ $dur }}"
                                        {{ old('duration', $service->duration) == $dur ? 'selected' : '' }}>
                                        {{ $dur }}
                                    </option>
                                @endforeach
                            </select>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Brief description of this service...">{{ old('description', $service->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Update Service
                        </button>
                        <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card border-0 shadow-sm border-start border-4" style="border-color:#c2185b !important;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Current Details</h6>
                <dl class="row mb-0 small">
                    <dt class="col-5 text-muted">Service</dt>
                    <dd class="col-7">{{ $service->name }}</dd>
                    <dt class="col-5 text-muted">Price</dt>
                    <dd class="col-7 fw-bold" style="color:#c2185b;">₱{{ number_format($service->price, 2) }}</dd>
                    <dt class="col-5 text-muted">Duration</dt>
                    <dd class="col-7">{{ $service->duration }}</dd>
                    <dt class="col-5 text-muted">Added</dt>
                    <dd class="col-7">{{ $service->created_at->format('M d, Y') }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
