<x-app-layout>
    <x-slot name="pageTitle">Add Rice Product</x-slot>

    <div class="page-header">
        <div>
            <h1>Add Rice Product</h1>
            <p>Fill in the details to list a new rice product.</p>
        </div>
        <a href="{{ route('rices.index') }}" class="btn btn-secondary">← Back to Products</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error){{ $error }}<br>@endforeach
        </div>
    @endif

    <div class="card" style="max-width:640px;">
        <div class="card-body">
            <form action="{{ route('rices.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Product Name</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="e.g. Jasmine Rice" required>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label class="form-label" for="price_per_kg">Price per KG (₱)</label>
                        <input class="form-control" type="number" step="0.01" name="price_per_kg" id="price_per_kg" value="{{ old('price_per_kg') }}" placeholder="0.00" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="stock">Stock (kg)</label>
                        <input class="form-control" type="number" name="stock" id="stock" value="{{ old('stock') }}" placeholder="0" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Description <span style="color:var(--text-muted); font-weight:400;">(optional)</span></label>
                    <textarea class="form-control" name="description" id="description" placeholder="Describe this rice variety...">{{ old('description') }}</textarea>
                </div>

                <div style="display:flex; gap:12px; margin-top:8px;">
                    <button type="submit" class="btn btn-primary">Create Product</button>
                    <a href="{{ route('rices.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>