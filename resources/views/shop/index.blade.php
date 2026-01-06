@extends('layouts.customer.customer')

@section('content')

{{-- ALERT CONTAINER --}}
<div id="alert-container"></div>

<h3 class="mb-3">
    <a href="{{ route('shop.index') }}" class="text-dark text-decoration-none">
        Products
    </a>
    @isset($selectedCategory)
        →
        @php
            $categoryChain = [];
            $current = $selectedCategory;
            while($current){
                array_unshift($categoryChain, $current); // store the full category object
                $current = $current->parent;
            }
        @endphp

        @foreach($categoryChain as $index => $category)
            <a href="{{ route('shop.category', $category->id) }}" class="text-primary text-decoration-none">
                {{ $category->name }}
            </a>
            @if($index < count($categoryChain) - 1)
                <span class="text-dark"> → </span>
            @endif
        @endforeach
    @endisset
</h3>


<div class="row">
    @forelse($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" height="200">
                @else
                    <img src="https://via.placeholder.com/150" class="card-img-top" height="200">
                @endif

                <div class="card-body text-center">
                    <h6>{{ $product->name }}</h6>
                    <p class="fw-bold text-success">₹{{ $product->price }}</p>

                    {{-- Button / Quantity --}}
                    <div class="cart-action d-flex justify-content-center align-items-center" 
                         data-id="{{ $product->id }}" 
                         data-stock="{{ $product->stock }}">
                        @php
                            $cart = session('cart', []);
                        @endphp
                        @if(isset($cart[$product->id]))
                            <button class="btn btn-sm btn-secondary decrease">-</button>
                            <span class="mx-2 qty">{{ $cart[$product->id]['quantity'] }}</span>
                            <button class="btn btn-sm btn-secondary increase">+</button>
                        @else
                            <button class="btn btn-primary add-to-cart">Add to Cart</button>
                        @endif
                    </div>
                    <!-- <p class="text-muted mt-1">Stock: {{ $product->stock }}</p> -->
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">
                No products found in this category.
            </div>
        </div>
    @endforelse

</div>

{{-- Bootstrap JS + jQuery --}}
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
<script>
$(document).ready(function() {

    // Show flash alert
    function showAlert(message, type='success') {
        var alertId = 'alert-' + Date.now();
        var alertHtml = `<div id="${alertId}" class="alert alert-${type} alert-dismissible fade show mt-2" role="alert">
                            ${message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                         </div>`;
        $('#alert-container').prepend(alertHtml);

        setTimeout(function() {
            var alertElement = document.getElementById(alertId);
            if(alertElement){
                bootstrap.Alert.getOrCreateInstance(alertElement).close();
            }
        }, 3500);
    }

    // ------------------- Add to Cart -------------------
    $(document).on('click', '.add-to-cart', function() {
        var container = $(this).closest('.cart-action');
        var productId = container.data('id');

        $.post("{{ url('/customer/cart/add') }}/" + productId, {_token: '{{ csrf_token() }}'}, function(response) {
            if(response.success){
                container.html(`
                    <button class="btn btn-sm btn-secondary decrease">-</button>
                    <span class="mx-2 qty">1</span>
                    <button class="btn btn-sm btn-secondary increase">+</button>
                `);
                $('#cart-count').text(response.cart_count); // update navbar
                showAlert(response.success, 'success');
            } else if(response.error){
                showAlert(response.error, 'danger');
            }
        });
    });

    // ------------------- Increase Quantity -------------------
    $(document).on('click', '.increase', function() {
      
        var container = $(this).closest('.cart-action');
        var qtyElem = container.find('.qty');
        var productId = container.data('id');

        $.post("{{ url('/customer/cart/update') }}", {
            _token: "{{ csrf_token() }}",
            id: productId,
            action: "increase"
        }, function(response) {
            console.log(response,'response')
            if(response.success){
                qtyElem.text(response.quantity);
                $('#cart-count').text(response.cart_count); // update navbar
                showAlert(response.success, 'success');
            }
            if(response.error){
                console.log(response,'response')
                showAlert(response.error, 'danger'); // stock limit reached
            }
        });
    });

    // ------------------- Decrease Quantity -------------------
    $(document).on('click', '.decrease', function() {
        var container = $(this).closest('.cart-action');
        var qtyElem = container.find('.qty');
        var productId = container.data('id');

        $.post("{{ url('/customer/cart/update') }}", {
            _token: "{{ csrf_token() }}",
            id: productId,
            action: "decrease"
        }, function(response) {
            if(response.success){
                if(response.quantity > 0){
                    qtyElem.text(response.quantity);
                    $('#cart-count').text(response.cart_count);
                    showAlert(response.success, 'success');
                } else {
                    container.html('<button class="btn btn-primary add-to-cart">Add to Cart</button>');
                    $('#cart-count').text(response.cart_count);
                    showAlert('Item removed from cart.', 'success');
                }
            } else if(response.error){
                showAlert(response.error, 'danger');
            }
        });
    });

});
</script>

@endsection
