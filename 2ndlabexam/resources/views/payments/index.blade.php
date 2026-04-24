<x-app-layout>
    <x-slot name="pageTitle">Payments</x-slot>

    <div class="page-header">
        <div>
            <h1>Payments</h1>
            <p>Track and manage all payment records.</p>
        </div>
        <a href="{{ route('payments.create') }}" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Process Payment
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Order ID</th>
                    <th>Rice Product</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td style="font-weight:600; color:var(--brown);">#{{ $payment->id }}</td>
                    <td>
                        <a href="{{ route('orders.show', $payment->order_id) }}" style="color:var(--brown); text-decoration:none; font-weight:500;">#{{ $payment->order_id }}</a>
                    </td>
                    <td>{{ $payment->order->rice->name ?? '—' }}</td>
                    <td style="font-weight:500;">₱{{ number_format($payment->amount, 2) }}</td>
                    <td>
                        @php $icons = ['cash' => '💵', 'card' => '💳', 'online' => '📱']; @endphp
                        <span>{{ $icons[$payment->payment_method] ?? '' }} {{ ucfirst($payment->payment_method) }}</span>
                    </td>
                    <td>
                        @if($payment->status === 'paid')
                            <span class="badge badge-success">Paid</span>
                        @else
                            <span class="badge badge-danger">Unpaid</span>
                        @endif
                    </td>
                    <td style="color:var(--text-muted); font-size:13px;">{{ $payment->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-outline btn-sm">View</a>
                            <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this payment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; color:var(--text-muted); padding:40px;">
                        No payments recorded yet. <a href="{{ route('payments.create') }}" style="color:var(--brown); font-weight:500;">Process your first payment →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-app-layout>