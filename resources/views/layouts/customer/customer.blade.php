<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>

    <!-- Bootstrap CSS (5.3.3) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <style>
/* Multi-level dropdown support */
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-left: 0;
    margin-right: 0;
}

.dropdown-menu > li:hover > .dropdown-menu {
    display: block;
}

.dropdown-submenu:hover > a {
    background-color: #f8f9fa;
}
/* #couponDropdown {
    position: relative;
    z-index: 9999;
}
.checkout-right {
    overflow: visible !important;
} */

</style>

</head>
<body class="bg-light">

    {{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand fw-bold d-flex align-items-center"
           href="{{ url('/') }}"
           style="
               color:#000;
               font-weight:700;
               font-family: 'Poppins', sans-serif;
               font-size: 1.25rem;      /* adjust if needed */
               line-height: 1.2;        /* keeps height consistent */
           "
           onmouseover="this.style.color='#111'"
           onmouseout="this.style.color='#000'">
            <i class="bi bi-box-fill me-2" style="color:#000;"></i>
            {{ config('app.name', 'Laravel') }}
        </a>

        <div class="dropdown me-4">
    <a class="btn secondary dropdown-toggle" href="#" role="button" id="categoriesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        Categories
    </a>

    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
        @foreach($categories->where('parent_id', null) as $category)
            @include('shop.category', ['category' => $category])
        @endforeach
    </ul>
</div>



        <div class="d-flex align-items-center ms-auto">
    <!-- Cart Icon -->
    <a href="{{ route('customer.cart.index') }}" class="text-decoration-none position-relative me-4  text-dark" style="font-size: 1 rem;">
        <i class="icon-basket-alt"></i>
        <span class="ms-1">Cart</span>
        <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ session('cart_count', 0) }}
        </span>
    </a>

    <!-- Simple Customer Name Dropdown -->
    @auth
    <div class="dropdown">
        <a href="#" class="text-decoration-none d-flex align-items-center fw-bold text-dark" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle me-2" style="font-size: 1.3rem;"></i>
            <span>{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
            <li>
                <a class="dropdown-item"
                   href="#">
                    My Profile
                </a>
            </li>
        
            <li>
                <a class="dropdown-item "
                   href="{{ route('customer.orders.index') }}">
                    My Orders
                </a>
            </li>
            <li>
                <a class="dropdown-item "
                   href="{{ route('customer.coupons.index') }}">
                    Coupons
                </a>
            </li>
            <li>
                <a class="dropdown-item text-danger" href="" id="customerLogout">
                    Logout
                </a>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

    </div>
    @endauth

    @guest
    <a href="{{ route('customer.login') }}" class="btn btn-outline-secondary ms-3">Login</a>
    @endguest
</div>

    </div>
</nav>




    

    {{-- CONTENT --}}
    <div class="container mt-4">
        @yield('content')
    </div>

    
    <!-- Popper + Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    @yield ('scripts')

    @stack('scripts')
    <!-- AJAX LOGOUT SCRIPT -->
    <script>
        $(document).on('click', '#customerLogout', function(e) {
            e.preventDefault();
        
            $.ajax({
                url: "{{ route('logout') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // Redirect to login page after successful logout
                    window.location.href = "{{ route('customer.login') }}";
                },
                error: function(xhr) {
                    console.error("Logout Error:", xhr.responseText);
                }
            });
        });
    </script>
</body>
</html>
