@extends('layouts.customer.customer')

@section('content')

<div class="container mt-4">

    <!-- Back Button -->
    <a href="javascript:history.back()" class="btn btn-secondary mb-3">← Back</a>
    
    <h3>Order #{{ $order->id }}</h3>

    <p><strong>Status:</strong>
        <span class="badge bg-primary">{{ ucfirst($order->status) }}</span>
    </p>

    <p><strong>Payment:</strong>
        <span class="badge bg-success">{{ ucfirst($order->payment_status) }}</span>
    </p>

    <hr>

    <table class="table table-bordered">

        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>₹{{ number_format($item['price'] * $item['quantity'],2) }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <h4 class="text-end">Total: ₹{{ number_format($order->total,2) }}</h4>

</div>

@endsection
