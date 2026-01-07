@extends('layouts.customer.customer')

@section('content')

{{-- ALERT CONTAINER --}}
<div id="alert-container"></div>

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<h3 class="mb-3">Your Cart</h3>

@if(session('cart') && count(session('cart')) > 0)
<table class="table table-bordered align-middle">
    <thead class="table-light">
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($cart as $id => $item)
        <tr>
            <td>
                @if(!empty($item['image']))
                    <img src="{{ asset('uploads/products/' . $item['image']) }}" width="60">
                @else
                    <span>No image</span>
                @endif
            </td>

            <td>{{ $item['name'] }}</td>

            <td>₹{{ $item['price'] }}</td>

            <td>
                <button class="btn btn-sm btn-secondary update-cart"
                        data-id="{{ $id }}" data-action="decrease">-</button>

                <span class="mx-2 quantity-{{ $id }}">{{ $item['quantity'] }}</span>

                <button class="btn btn-sm btn-secondary update-cart"
                        data-id="{{ $id }}" data-action="increase">+</button>
            </td>

            <td class="item-total-{{ $id }}">
                ₹{{ number_format($item['price'] * $item['quantity'], 2) }}
            </td>

            <td>
                <button class="btn btn-sm btn-danger remove-item"
                        data-id="{{ $id }}">Remove</button>
            </td>
        </tr>
        @endforeach

        <tr>
            <td colspan="5" class="text-end fw-bold">Grand Total</td>
            <td colspan="2" class="fw-bold" id="grand-total-value">₹{{ number_format($total, 2) }}</td>
        </tr>

    </tbody>
</table>

@if(session('cart') && count(session('cart')) > 0)
    <!-- Your table here -->

    <div class="mt-3 d-flex justify-content-between">
        <!-- Continue Shopping -->
        <a href="{{ route('shop.index') }}" class="btn btn-secondary btn-lg">
            <i class="bi bi-arrow-left-circle me-1"></i> Continue Shopping
        </a>

        <!-- Checkout -->
        <a href="{{ route('customer.checkout') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-cart-check me-1"></i> Checkout
        </a>
    </div>
@endif


@else
<p>Your cart is empty.</p>
@endif

@endsection


@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    //console.log("Cart JS Loaded ✔");

    // fixed - added a reusable formatter (same as number_format)

    function formatCurrency(amount) {
        return '₹' + parseFloat(amount).toFixed(2);
    }

    // UPDATE CART (increase/decrease)
    $('.update-cart').click(function (e) {
        e.preventDefault();

        let id = $(this).data('id');
        let action = $(this).data('action');

        $.ajax({
            url: "{{ route('customer.cart.update') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                action: action
            },
            success: function (response) {

                if (response.error) {
                    showAlert(response.error, 'danger');
                    return;
                }

                if (response.quantity === 0) {
                    $('tr').has('.update-cart[data-id="' + id + '"]').remove();
                } else {
                    $('.quantity-' + id).text(response.quantity);

                    // let price = parseFloat(
                    //     $('button[data-id="' + id + '"]')
                    //     .closest('tr')
                    //     .find('td:nth-child(3)')
                    //     .text()
                    //     .replace('₹', '')
                    // );

                    // Update the item's total and grand total
                    $('.item-total-' + id).text(formatCurrency(response.itemTotal));
                    $('#grand-total-value').text(formatCurrency(response.grandTotal));

                }

                if (response.cart_count !== undefined) {
                    $("#cart-count").text(response.cart_count);
                }

                showAlert(response.success);
                refreshTotals();
            }
        });
    });

    // REMOVE ITEM
    $('.remove-item').click(function (e) {
        e.preventDefault();

        let id = $(this).data('id');

        $.ajax({
           url: "{{ url('customer/cart/remove') }}/" + id,
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {

                if (response.error) {
                    showAlert(response.error, 'danger');
                    return;
                }

                showAlert(response.success);

                $('tr').has('.remove-item[data-id="' + id + '"]').remove();

                if (response.cart_count !== undefined) {
                    $("#cart-count").text(response.cart_count);
                }

                refreshTotals();
            }
        });
    });

    // Refresh Grand Total
    function refreshTotals() {
        $.ajax({
            url: "{{ route('customer.cart.index') }}",
            method: "GET",
            success: function (html) {
                let newTotal = $(html).find('#grand-total-value').text();
                $('#grand-total-value').text(newTotal);
            }
        });
    }

    // Alert Function
    function showAlert(message, type = 'success') {
        let alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show mt-2">
                ${message}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $('#alert-container').html(alertHtml);
    }

});
</script>
@endsection
