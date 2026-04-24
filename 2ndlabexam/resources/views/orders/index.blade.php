<x-app-layout>
    <x-slot name="pageTitle">Orders</x-slot>

    <div class="page-header">
        <div>
            <h1>Orders</h1>
            <p>View and manage all customer orders.</p>
        </div>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Order
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Rice Product</th>
                    <th>Qty (kg)</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td style="font-weight:600; color:var(--brown);">#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->rice->name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td style="font-weight:500;">₱{{ number_format($order->total_price, 2) }}</td>
                    <td>
                        @if($order->status === 'completed')
                            <span class="badge badge-success">Completed</span>
                        @elseif($order->status === 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-danger">Cancelled</span>
                        @endif
                    </td>
                    <td style="color:var(--text-muted); font-size:13px;">{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline btn-sm">View</a>
                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this order?')">
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
                        No orders yet. <a href="{{ route('orders.create') }}" style="color:var(--brown); font-weight:500;">Create your first order →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-app-layout>