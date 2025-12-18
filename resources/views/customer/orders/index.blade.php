@extends('layouts.customer.customer')

@section('content')

<div class="container mt-4">

    <h3 class="mb-3">My Orders</h3>

    <table class="table table-bordered">

        <thead>
            <tr>
                <th>Order ID</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Date</th>
                <th>View</th>
            </tr>
        </thead>

        <tbody>

            @forelse($orders as $order)

            <tr>
                <td>{{ $order->id }}</td>
                <td>₹{{ number_format($order->total,2) }}</td>

                <td>
                    <span class="badge bg-success">{{ ucfirst($order->payment_status) }}</span>
                </td>

                <td>
                    <span class="badge bg-primary">{{ ucfirst($order->status) }}</span>
                </td>

                <td>{{ $order->created_at->format('d M Y') }}</td>

                <td>
                    <a href="{{ route('customer.orders.show',$order->id) }}" 
                       class="btn btn-sm btn-info">View</a>
                </td>

            </tr>

            @empty
                <tr>
                    <td colspan="6" class="text-center">No orders found</td>
                </tr>
            @endforelse

        </tbody>

    </table>

</div>

@endsection
