@extends('layouts.customer.customer')
<pre>{{ print_r($order->toArray(), true) }}</pre>

@section('content')

<style>
    .success-check {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: #28a745;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    .success-check i {
        font-size: 55px;
        color: white;
    }
    .order-item img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
    }
</style>

<div class="container my-5">

    <!-- Success animation -->
    <div class="text-center mb-4">
        <div class="success-check mb-3">
            <i class="bi bi-check-lg"></i>
        </div>
        <h2 class="fw-bold text-success">Payment Successful!</h2>
        <p class="text-muted">Thank you! Your order has been placed successfully.</p>
    </div>

    <div class="row mt-4">

        <!-- Shipping Details -->
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h4 class="fw-bold mb-3">Shipping Details</h4>

                <p><strong>Name:</strong> {{ $order->name }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Phone:</strong> {{ $order->phone }}</p>
                <p><strong>Address:</strong> {{ $order->address }}</p>
                <p><strong>City:</strong> {{ $order->city }}</p>
                <p><strong>State:</strong> {{ $order->state }}</p>
                <p><strong>Pincode:</strong> {{ $order->pincode }}</p>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h4 class="fw-bold mb-3">Order Summary</h4>

                @foreach ($order->items as $item)
<div class="d-flex align-items-center justify-content-between mb-3 order-item">
    <div class="d-flex align-items-center">
        <img src="{{ asset('storage/' . $item['image']) }}" alt="Product">

        <div class="ms-3">
            <h6 class="fw-bold">{{ $item['name'] }}</h6>
            <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
        </div>
    </div>

    <h6 class="fw-bold">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</h6>
</div>
@endforeach


                <hr>

                {{-- Subtotal --}}
                <div class="d-flex justify-content-between">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($order->subtotal, 2) }}</span>
                </div>
                
                {{-- Coupon Discount --}}
                @if($order->discount_amount > 0)
                    <div class="d-flex justify-content-between text-success mt-1">
                        <span>
                            Coupon ({{ $order->coupon_code }})
                        </span>
                        <span>
                            - ₹{{ number_format($order->discount_amount, 2) }}
                        </span>
                    </div>
                @endif
                
                <hr>
                
                {{-- Final Payable --}}
                <div class="d-flex justify-content-between mt-2">
                    <h5 class="fw-bold">Total Amount</h5>
                    <h5 class="fw-bold text-dark">
                        ₹{{ number_format($order->total, 2) }}
                    </h5>
                </div>


            </div>
        </div>

    </div>

    <!-- Continue Shopping Button -->
    <div class="text-center mt-4">
        <a href="{{ route('shop.index') }}" class="btn btn-success btn-lg px-4">
            Continue Shopping
        </a>
    </div>
</div>

@endsection
