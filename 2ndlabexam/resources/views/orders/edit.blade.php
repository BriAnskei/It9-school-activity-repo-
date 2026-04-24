<x-app-layout>
    <x-slot name="pageTitle">Edit Order</x-slot>

    <div class="page-header">
        <div>
            <h1>Edit Order <span style="color:var(--brown); font-weight:700;">#{{ $order->id }}</span></h1>
            <p>Update the order details or change its status.</p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Orders
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <div class="table-wrap" style="max-width: 640px;">
        <form method="POST" action="{{ route('orders.update', $order->id) }}" style="padding: 8px 0;">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="rice_id">Rice Product</label>
                <select name="rice_id" id="rice_id" class="form-control" required>
                    @foreach($rices as $rice)
                        <option value="{{ $rice->id }}"
                            data-price="{{ $rice->price_per_kg }}"
                            {{ $order->rice_id == $rice->id ? 'selected' : '' }}>
                            {{ $rice->name }} — ₱{{ number_format($rice->price_per_kg, 2) }}/kg
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="quantity">Quantity (kg)</label>
                <input type="number" name="quantity" id="quantity" class="form-control"
                    step="0.1" min="0.1" value="{{ old('quantity', $order->quantity) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="pending"   {{ $order->status == 'pending'   ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="price-summary">
                <div class="price-row">
                    <span>Price per kg</span>
                    <span id="price-per-kg" style="font-weight:600; color:var(--brown);">₱{{ number_format($order->rice->price_per_kg, 2) }}</span>
                </div>
                <div class="price-row">
                    <span>Total Cost</span>
                    <span id="total-cost" style="font-size:18px; font-weight:700; color:var(--brown);">₱{{ number_format($order->total_price, 2) }}</span>
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:24px;">
                <button type="submit" class="btn btn-primary">Update Order</button>
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>

    <style>
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted, #6b7280);
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .form-control {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            color: inherit;
            background: #fafaf9;
            box-sizing: border-box;
            transition: border-color .15s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--brown, #92400e);
            background: #fff;
        }
        .price-summary {
            background: #fdf8f3;
            border: 1.5px solid #f0e6d8;
            border-radius: 10px;
            padding: 16px 20px;
            margin-top: 8px;
        }
        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            font-size: 14px;
        }
        .price-row + .price-row {
            border-top: 1px solid #f0e6d8;
            margin-top: 6px;
            padding-top: 12px;
        }
        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>

    <script>
        const riceSelect = document.getElementById('rice_id');
        const quantityInput = document.getElementById('quantity');
        const pricePerKgEl = document.getElementById('price-per-kg');
        const totalCostEl = document.getElementById('total-cost');

        function calculateTotal() {
            const opt = riceSelect.options[riceSelect.selectedIndex];
            const price = parseFloat(opt?.dataset?.price) || 0;
            const qty = parseFloat(quantityInput.value) || 0;
            pricePerKgEl.textContent = '₱' + price.toFixed(2);
            totalCostEl.textContent = '₱' + (price * qty).toFixed(2);
        }

        riceSelect.addEventListener('change', calculateTotal);
        quantityInput.addEventListener('input', calculateTotal);
    </script>
</x-app-layout>