{{-- COUPON SECTION --}}
<div class="mb-3">

    @if(session()->has('applied_coupon'))
        <div class="alert alert-success d-flex justify-content-between align-items-center">
            <div>
                Coupon <strong>{{ session('applied_coupon.code') }}</strong>
                (−₹{{ number_format(session('applied_coupon.discount'), 2) }})
            </div>
            <button class="btn btn-sm btn-danger" id="removeCoupon">Remove</button>
        </div>
    @else

        <label class="fw-bold mb-1">Select a Coupon</label>
        <p class="text-danger fw-bold">DROPDOWN START</p>
        <select id="couponDropdown" class="form-select mb-2">
            <option value="">-- Choose Coupon --</option>

            @foreach($coupons as $coupon)
                <option value="{{ $coupon->code }}">
                    {{ $coupon->code }}
                    @if($coupon->type === 'percentage')
                        ({{ $coupon->value }}% OFF)
                    @else
                        (₹{{ $coupon->value }} OFF)
                    @endif
                </option>
            @endforeach
        </select>
        <p class="text-danger fw-bold">DROPDOWN END</p>

        <div class="input-group">
            <input type="text"
                   id="coupon_code"
                   class="form-control"
                   placeholder="Enter coupon code">

            <button type="button" class="btn btn-outline-dark" id="applyCoupon">
                Apply
            </button>
        </div>

        <small class="text-danger d-none" id="couponError"></small>

    @endif
</div>
