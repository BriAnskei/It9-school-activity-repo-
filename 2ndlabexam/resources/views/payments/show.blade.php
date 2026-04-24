<x-app-layout>
    <x-slot name="pageTitle">Payment Details</x-slot>

    <div class="page-header">
        <div>
            <h1>Payment #{{ $payment->id }}</h1>
            <p>Recorded on {{ $payment->created_at->format('F d, Y \a\t g:i A') }}</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-primary">Edit Payment</a>
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="card" style="max-width:680px;">
        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">Payment ID</div>
                <div class="detail-value" style="font-family:'Playfair Display',serif;">#{{ $payment->id }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    @if($payment->status === 'paid')
                        <span class="badge badge-success">Paid</span>
                    @else
                        <span class="badge badge-danger">Unpaid</span>
                    @endif
                </div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Order ID</div>
                <div class="detail-value">
                    <a href="{{ route('orders.show', $payment->order_id) }}" style="color:var(--brown); text-decoration:none; font-weight:500;">#{{ $payment->order_id }}</a>
                </div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Customer</div>
                <div class="detail-value">{{ $payment->order->user->name ?? '—' }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Rice Product</div>
                <div class="detail-value">{{ $payment->order->rice->name ?? '—' }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Quantity</div>
                <div class="detail-value">{{ $payment->order->quantity ?? '—' }} kg</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Amount Paid</div>
                <div class="detail-value" style="font-family:'Playfair Display',serif; font-size:22px; color:var(--brown);">₱{{ number_format($payment->amount, 2) }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Payment Method</div>
                <div class="detail-value">
                    @php $icons = ['cash' => '💵', 'card' => '💳', 'online' => '📱']; @endphp
                    {{ $icons[$payment->payment_method] ?? '' }} {{ ucfirst($payment->payment_method) }}
                </div>
            </div>
            <div class="detail-item detail-full">
                <div class="detail-label">Payment Date</div>
                <div class="detail-value">{{ $payment->created_at->format('F d, Y \a\t g:i A') }}</div>
            </div>
        </div>
    </div>

</x-app-layout>