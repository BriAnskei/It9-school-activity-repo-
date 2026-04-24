<x-app-layout>
    <x-slot name="pageTitle">Edit Payment</x-slot>

    <div class="page-header">
        <div>
            <h1>Edit Payment #{{ $payment->id }}</h1>
            <p>Update payment method or status for Order #{{ $payment->order_id }}.</p>
        </div>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">← Back to Payments</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="max-width:640px;">
            @foreach($errors->all() as $error){{ $error }}<br>@endforeach
        </div>
    @endif

    <div style="display:grid; grid-template-columns:1fr 300px; gap:24px; max-width:860px; align-items:start;">

        <div class="card">
            <div class="card-body">
                <form action="{{ route('payments.update', $payment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label" for="payment_method">Payment Method</label>
                        <select class="form-control" name="payment_method" id="payment_method" required>
                            <option value="cash"   {{ $payment->payment_method === 'cash'   ? 'selected' : '' }}>💵 Cash</option>
                            <option value="card"   {{ $payment->payment_method === 'card'   ? 'selected' : '' }}>💳 Card</option>
                            <option value="online" {{ $payment->payment_method === 'online' ? 'selected' : '' }}>📱 Online</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="status">Payment Status</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="paid"   {{ $payment->status === 'paid'   ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ $payment->status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                    </div>

                    <div style="display:flex; gap:12px; margin-top:8px;">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order context card -->
        <div class="card" style="border:1.5px solid var(--cream-dark);">
            <div class="card-body">
                <h4 style="font-family:'Playfair Display',serif; font-size:15px; color:var(--brown-dark); margin-bottom:16px;">Order Info</h4>
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <div>
                        <div style="font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--text-muted); margin-bottom:3px;">Order</div>
                        <div style="font-weight:500;">#{{ $payment->order_id }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--text-muted); margin-bottom:3px;">Rice Product</div>
                        <div style="font-weight:500;">{{ $payment->order->rice->name ?? '—' }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--text-muted); margin-bottom:3px;">Amount</div>
                        <div style="font-family:'Playfair Display',serif; font-size:20px; font-weight:600; color:var(--brown);">₱{{ number_format($payment->amount, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>