<x-app-layout>
    <x-slot name="pageTitle">Rice Product Details</x-slot>

    <div class="page-header">
        <div>
            <h1>{{ $rice->name }}</h1>
            <p>Rice product details and information.</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('rices.edit', $rice->id) }}" class="btn btn-primary">Edit Product</a>
            <a href="{{ route('rices.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="card" style="max-width:640px;">
        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">Product Name</div>
                <div class="detail-value">{{ $rice->name }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Price per KG</div>
                <div class="detail-value" style="color:var(--brown); font-weight:600;">₱{{ number_format($rice->price_per_kg, 2) }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Stock Available</div>
                <div class="detail-value">
                    @if($rice->stock < 10)
                        <span class="badge badge-danger">{{ $rice->stock }} kg — Low Stock</span>
                    @else
                        <span class="badge badge-success">{{ $rice->stock }} kg</span>
                    @endif
                </div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Date Added</div>
                <div class="detail-value">{{ $rice->created_at->format('M d, Y') }}</div>
            </div>
            <div class="detail-item detail-full">
                <div class="detail-label">Description</div>
                <div class="detail-value" style="font-weight:400; color:var(--text-muted);">{{ $rice->description ?? 'No description provided.' }}</div>
            </div>
        </div>
    </div>

</x-app-layout>