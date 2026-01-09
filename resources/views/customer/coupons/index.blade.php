@extends('layouts.customer.customer')

@section('content')
<h3 class="fw-bold mb-4">Available Coupons</h3>

@if($coupons->isEmpty())
    <div class="alert alert-warning">
        No coupons available for you right now.
    </div>
@else
<div class="row">
    @foreach($coupons as $coupon)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold text-primary d-flex align-items-center gap-2">
                        <span id="coupon-code-{{ $coupon->id }}">
                            {{ $coupon->code }}
                        </span>
                    
                        <i class="bi bi-copy text-secondary ms-auto"
                           style="cursor:pointer"
                           title="Copy coupon"
                           onclick="copyCoupon('coupon-code-{{ $coupon->id }}', this)">
                        </i>
                    </h5>


                    <p class="mb-1">
                        <strong>Discount:</strong>
                        @if($coupon->type === 'percentage')
                            {{ $coupon->value }}% OFF
                        @else
                            ₹{{ $coupon->value }} OFF
                        @endif
                    </p>

                    @if($coupon->min_order_amount)
                        <p class="mb-1">
                            <strong>Min Order:</strong>
                            ₹{{ number_format($coupon->min_order_amount, 2) }}
                        </p>
                    @endif

                    <p class="mb-1">
                        <strong>Expires:</strong>
                        {{ $coupon->end_date ? $coupon->end_date->format('d M Y') : 'No expiry' }}
                    </p>

                    <span class="badge bg-success mt-2">
                        Available
                    </span>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endif


<script>
function copyCoupon(elementId, icon) {
    const text = document.getElementById(elementId).innerText;

    navigator.clipboard.writeText(text).then(() => {

        // Change icon to check
        icon.classList.remove('bi-copy');
        icon.classList.add('bi-check-lg', 'text-success');

        // Revert back after 2 seconds
        setTimeout(() => {
            icon.classList.remove('bi-check-lg', 'text-success');
            icon.classList.add('bi-copy', 'text-secondary');
        }, 2000);
    });
}
</script>

@endsection
