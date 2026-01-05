@php
    $subtotal = session('cart_total', 0);
    $discount = session('applied_coupon.discount', 0);
    $payable  = $subtotal - $discount;
@endphp

<div class="card p-3">
    <h6>Order Summary</h6>

    <div class="d-flex justify-content-between">
        <span>Subtotal</span>
        <span>₹{{ number_format($subtotal, 2) }}</span>
    </div>

    @if(session()->has('applied_coupon'))
        <div class="d-flex justify-content-between text-success">
            <span>
                Coupon ({{ session('applied_coupon.code') }})
            </span>
            <span>−₹{{ number_format($discount, 2) }}</span>
        </div>
    @endif

    <hr>

    <div class="d-flex justify-content-between fw-bold">
        <span>Payable</span>
        <span>₹{{ number_format($payable, 2) }}</span>
    </div>
</div>
