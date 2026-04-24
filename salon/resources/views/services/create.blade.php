@extends('layouts.app')

@section('title', 'Add Service')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('services.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Add New Service</h5>
        <small class="text-muted">Fill in the details below</small>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('services.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Service Name <span class="text-danger">*</span></label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
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
                                   value="{{ old('price') }}"
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
                                    <option value="{{ $dur }}" {{ old('duration') == $dur ? 'selected' : '' }}>
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
                                  placeholder="Brief description of this service...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Save Service
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
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-lightbulb me-2 text-warning"></i>Quick Add Examples</h6>
                <p class="text-muted small mb-3">Click any to pre-fill the form:</p>
                <div class="d-flex flex-wrap gap-2">
                    @foreach([
                        ['name'=>'Manicure','price'=>150,'duration'=>'30 mins','description'=>'Classic nail care including shaping, cuticle care, and polish.'],
                        ['name'=>'Pedicure','price'=>200,'duration'=>'45 mins','description'=>'Full foot care with soak, scrub, nail trim, and polish.'],
                        ['name'=>'Gel Polish','price'=>300,'duration'=>'1 hour','description'=>'Long-lasting gel color with UV cure finish.'],
                        ['name'=>'Nail Extension','price'=>500,'duration'=>'2 hours','description'=>'Acrylic or gel nail extension for length and design.'],
                        ['name'=>'Nail Art','price'=>250,'duration'=>'1 hour','description'=>'Custom nail designs and decorations.'],
                    ] as $ex)
                    <button type="button"
                            class="btn btn-sm btn-outline-secondary"
                            onclick="prefill({{ json_encode($ex) }})">
                        {{ $ex['name'] }}
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function prefill(data) {
    document.querySelector('[name=name]').value = data.name;
    document.querySelector('[name=price]').value = data.price;
    document.querySelector('[name=description]').value = data.description;
    const sel = document.querySelector('[name=duration]');
    for (let o of sel.options) {
        if (o.value === data.duration) { o.selected = true; break; }
    }
}
</script>
@endsection
