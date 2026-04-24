<x-app-layout>
    <x-slot name="pageTitle">Rice Products</x-slot>

    <div class="page-header">
        <div>
            <h1>Rice Products</h1>
            <p>Manage your rice product catalog.</p>
        </div>
        <a href="{{ route('rices.create') }}" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Product
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price per KG</th>
                    <th>Stock</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rices as $rice)
                <tr>
                    <td style="font-weight:500; color:var(--brown-dark);">{{ $rice->name }}</td>
                    <td style="font-weight:500;">₱{{ number_format($rice->price_per_kg, 2) }}</td>
                    <td>
                        @if($rice->stock < 10)
                            <span class="badge badge-danger">{{ $rice->stock }} kg</span>
                        @else
                            <span class="badge badge-success">{{ $rice->stock }} kg</span>
                        @endif
                    </td>
                    <td style="color:var(--text-muted); max-width:220px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $rice->description ?? '—' }}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('rices.show', $rice->id) }}" class="btn btn-outline btn-sm">View</a>
                            <a href="{{ route('rices.edit', $rice->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form action="{{ route('rices.destroy', $rice->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this rice product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; color:var(--text-muted); padding:40px;">
                        No rice products yet. <a href="{{ route('rices.create') }}" style="color:var(--brown); font-weight:500;">Add your first product →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-app-layout>