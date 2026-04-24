<x-app-layout>
    <x-slot name="pageTitle">Order Details</x-slot>

    <div class="page-header">
        <div>
            <h1>Order <span style="color:var(--brown); font-weight:700;">#{{ $order->id }}</span></h1>
            <p>Viewing full details for this order.</p>
        </div>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-secondary">Edit</a>
            <a href="{{ route('orders.index') }}" class="btn btn-outline">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to Orders
            </a>
        </div>
    </div>

    <div class="table-wrap" style="max-width: 680px; padding: 0;">
        <table style="margin:0;">
            <tbody>
                <tr>
                    <td class="detail-label">Order ID</td>
                    <td style="font-weight:700; color:var(--brown);">#{{ $order->id }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Customer</td>
                    <td>{{ $order->user->name }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Rice Product</td>
                    <td>{{ $order->rice->name }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Price per kg</td>
                    <td>₱{{ number_format($order->rice->price_per_kg, 2) }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Quantity</td>
                    <td>{{ $order->quantity }} kg</td>
                </tr>
                <tr>
                    <td class="detail-label">Total Price</td>
                    <td style="font-weight:700; font-size:15px;">₱{{ number_format($order->total_price, 2) }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Status</td>
                    <td>
                        @if($order->status === 'completed')
                            <span class="badge badge-success">Completed</span>
                        @elseif($order->status === 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-danger">Cancelled</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="detail-label">Date Placed</td>
                    <td style="color:var(--text-muted); font-size:13px;">{{ $order->created_at->format('M d, Y · h:i A') }}</td>
                </tr>
                @if($order->payment)
                <tr>
                    <td class="detail-label">Payment Status</td>
                    <td>
                        @if($order->payment->status === 'paid')
                            <span class="badge badge-success">Paid</span>
                        @elseif($order->payment->status === 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-danger">{{ ucfirst($order->payment->status) }}</span>
                        @endif
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <style>
        .detail-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted, #6b7280);
            text-transform: uppercase;
            letter-spacing: .04em;
            width: 160px;
            padding: 14px 20px;
        }
        .table-wrap tbody td {
            padding: 14px 20px;
            vertical-align: middle;
        }
        .table-wrap tbody tr:last-child td {
            border-bottom: none;
        }
    </style>
</x-app-layout>