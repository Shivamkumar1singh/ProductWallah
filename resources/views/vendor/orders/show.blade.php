@extends('vendor.layouts.vendor')

@section('content')

<div class="container mt-4">
    <h3>
        Order #{{ $order->id }}
    </h3>

    <div class="card mt-3">
        <div class="card-header fw-bold">Customer Details</div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $order->name }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Phone:</strong> {{ $order->phone }}</p>
            <p><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header fw-bold">Order Status</div>
        <div class="card-body">
    
            <p>
                <strong>Order Status:</strong>
                <span class="badge bg-info">{{ ucfirst($order->status ?? 'Pending') }}</span>
            </p>
    
            <!-- <p>
                <strong>Payment Status:</strong>
                <span class="badge bg-success">{{ ucfirst($order->payment_status ?? 'Pending') }}</span>
            </p> -->
    
            <!-- <hr>
    
            {{-- Update Order Status --}}
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mb-3">
                @csrf
                @method('PUT')
    
                <label class="fw-bold">Update Order Status:</label>
                <select name="status" class="form-select mt-1" style="max-width:300px;">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
    
                <button class="btn btn-primary btn-sm mt-2">Update</button>
            </form> -->
    
        </div>
    </div>


    <div class="card mt-4">
        <div class="card-header fw-bold">Order Items</div>
        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>

                <tbody>
                    

                    @foreach ($order->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>
                            ₹{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}
                        </td>
                    </tr>
                    @endforeach


                </tbody>

            </table>

            @php
                $vendorTotal = $order->products->sum(fn($product) =>
                    $product->pivot->price * $product->pivot->quantity
                );
            @endphp
            
            <h4 class="text-end mt-3">
                Total: ₹{{ number_format($vendorTotal, 2) }}
            </h4>


        </div>
    </div>
</div>

@endsection
