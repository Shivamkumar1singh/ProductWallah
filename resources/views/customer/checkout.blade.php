@extends('layouts.customer.customer')


@section('content')

<style>
    .checkout-wrapper {
        display: flex;
        gap: 30px;
        margin-top: 25px;
    }

    .checkout-left, .checkout-right {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .checkout-left {
        flex: 2;
    }

    .checkout-right {
        flex: 1;
        height: fit-content;
        position: sticky;
        top: 100px;
    }

    .product-item {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
        display: flex;
        justify-content: space-between;
    }
</style>

<h3 class="fw-bold mb-3">Checkout</h3>

@if(session('cart') && count(session('cart')) > 0)

<div class="checkout-wrapper">

    <!-- LEFT -->
    <div class="checkout-left">
        <h5 class="fw-bold mb-3">Shipping Details</h5>

        <form id="shippingForm">

            <div class="mb-3">
                <label class="form-label fw-bold">Full Name</label>
                <input type="text" id="full_name" class="form-control" placeholder="Enter your full name" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" id="email" class="form-control" placeholder="Enter your email" required>
                
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Phone Number</label>
                <input type="tel"
                       id="phone"
                       class="form-control"
                       required
                       pattern="[6-9]{1}[0-9]{9}"
                       maxlength="10"
                       placeholder="Enter 10-digit mobile number">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Address</label>
                <textarea id="address" class="form-control" rows="3" placeholder="Enter your Address" required></textarea>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label class="form-label fw-bold">City</label>
                    <input type="text" id="city" class="form-control" placeholder="Enter your City" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">State</label>
                    <input type="text" id="state" class="form-control" placeholder="Enter your State " required>
                </div>
                

                <div class="col-md-6">
                    <label class="form-label fw-bold">Pincode</label>
                    <input type="text" id="pincode" class="form-control"
                           pattern="^[1-9][0-9]{5}$"
                           maxlength="6"
                           placeholder="Enter your Pincode" 
                           required>
                    <small class="text-danger d-none" id="pincodeError">
                        Please enter a valid 6-digit Indian pincode.
                    </small>
                </div>
            </div>
        </form>

    </div>

    <!-- RIGHT -->
    <div class="checkout-right">
        <h5 class="fw-bold mb-3">Order Summary</h5>

        @php $total = 0; @endphp

        @foreach(session('cart') as $item)
        <div class="product-item d-flex align-items-center justify-content-between">
        
            <!-- LEFT SIDE (Image + Name + Qty) -->
            <div class="d-flex align-items-center">
                <img src="{{ asset('storage/' . $item['image']) }}" 
                     alt="{{ $item['name'] }}" 
                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; margin-right: 12px;">
        
                <div>
                    <div class="fw-bold">{{ $item['name'] }}</div>
                    <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                </div>
            </div>
        
            <!-- RIGHT SIDE (Price x Qty) -->
            <span class="fw-bold">
                ₹{{ number_format($item['price'] * $item['quantity'], 2) }}
            </span>
        
        </div>
        @php $total += $item['price'] * $item['quantity']; @endphp
        @endforeach
            
        

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

        <label class="fw-bold mb-1">Apply Coupon</label>
        <!-- <p class="text-dark fw-bold">DROPDOWN START</p> -->
        <!-- <select id="couponDropdown" class="form-select mb-2">
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
        </select> -->
        <!-- <p class="text-dark fw-bold">DROPDOWN END</p> -->

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


        <hr>
        
        <div class="d-flex justify-content-between">
            <span>Subtotal Amount</span>
            <span>₹{{ number_format($subtotal, 2) }}</span>
        </div>
        
        @if(session()->has('applied_coupon'))
        <div class="d-flex justify-content-between text-success">
            <span>Coupon ({{ session('applied_coupon.code') }})</span>
            <span>- ₹{{ number_format(session('applied_coupon.discount'), 2) }}</span>
        </div>
        @endif
        
        <hr>
        
        <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
            <span>Payable Amount</span>
            <span>₹{{ number_format($payable, 2) }}</span>
        </div>


        <button id="payBtn" class="btn btn-dark w-100">Pay with Stripe</button>
        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary w-100 mt-2">Continue Shopping</a>

        <div id="payment-message" class="mt-3"></div>
    </div>

</div>

@else
    <p>Your cart is empty.</p>
@endif

@endsection


@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
$(document).ready(function() {

    const stripe = Stripe("{{ config('services.stripe.key') }}");

    function validateShippingForm() {
        let isValid = true;

        $("#shippingForm input, #shippingForm textarea").each(function () {
            if ($(this).val().trim() === "") {
                $(this).addClass("is-invalid");
                isValid = false;
            } else {
                $(this).removeClass("is-invalid");
            }
        });

        return isValid;
    }

    $('#payBtn').click(function(e) {
        e.preventDefault();
    
        if (!validateShippingForm()) {
            $('#payment-message').html(`<div class="alert alert-danger">Please fill all required shipping details.</div>`);
            return;
        }
    
        $(this).attr('disabled', true).text('Processing...');
    
        let shipping = {
            full_name: $("#full_name").val(),
            email: $("#email").val(),
            phone: $("#phone").val(),
            address: $("#address").val(),
            city: $("#city").val(),
            state: $("#state").val(),
            pincode: $("#pincode").val()
        };
    
        // 👉 First save shipping details in session
        $.ajax({
            url: "{{ route('customer.checkout.save.shipping') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                shipping: shipping
            },
            success: function() {
    
                // 👉 Now start the stripe session
                $.ajax({
                    url: "{{ route('customer.checkout.stripe') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
    
                        if(response.error){
                            $('#payment-message').html(`<div class="alert alert-danger">${response.error}</div>`);
                            $('#payBtn').attr('disabled', false).text('Pay with Stripe');
                            return;
                        }
    
                        stripe.redirectToCheckout({
                            sessionId: response.sessionId
                        });
                    }
                });
    
            }
        });
    
    });

    $('#couponDropdown').on('change', function () {
        $('#coupon_code').val($(this).val());
    });

    // APPLY COUPON
    $('#applyCoupon').on('click', function (e) {
        e.preventDefault();
    
        let code = $('#coupon_code').val().trim();
    
        if (!code) {
            $('#couponError').text('Please enter a coupon code')
                             .removeClass('d-none');
            return;
        }
    
        $.ajax({
            url: "{{ route('customer.coupon.apply') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                coupon_code: code,
                order_total: {{ (int) $total }}
            },
            success: function (response) {
                if (!response.success) {
                    $('#couponError')
                        .text(response.message)
                        .removeClass('d-none');
                } else {
                    location.reload();
                }
            },
            error: function (xhr) {
                let msg = xhr.responseJSON?.message ?? 'Coupon cannot be applied';
                $('#couponError').text(msg).removeClass('d-none');
            }
        });

    });
    
    // REMOVE COUPON
    $('#removeCoupon').on('click', function () {
    
        $.ajax({
            url: "{{ route('customer.coupon.remove') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function () {
                location.reload();
            }
        });
    });

});



document.getElementById("pincode").addEventListener("input", function () {
    const pin = this.value;
    const regex = /^[1-9][0-9]{5}$/;

    if (!regex.test(pin)) {
        this.classList.add("is-invalid");
        document.getElementById("pincodeError").classList.remove("d-none");
    } else {
        this.classList.remove("is-invalid");
        document.getElementById("pincodeError").classList.add("d-none");
    }
});

</script>

@endpush
