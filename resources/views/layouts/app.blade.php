<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image" href="{{ asset('admin/assets/images/favicon.svg') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">



    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    transition: all 0.3s ease;
}

    


    </style>
</head>
<body style="
    background-image: url('{{ asset('admin/assets/images/background_image.jpg') }}');
    background-repeat: no-repeat;
    /* background-size: contain;   shows full image */
    background-position: center top;
    background-color: #000;     /*your image has black background, blend perfectly */
    height: 100vh;
    
">
    
        <nav class="navbar navbar-expand-lg navbar-light py-3"
     style="background: transparent !important; box-shadow: none !important;">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand fw-bold d-flex align-items-center"
           href="{{ url('/') }}"
           style="
               color:white;
               font-weight:700;
               font-family: 'Poppins', sans-serif;
               font-size: 1.25rem;      /* adjust if needed */
               line-height: 1.2;        /* keeps height consistent */
           "
           onmouseover="this.style.color='#ffffffff'"
           onmouseout="this.style.color='#fcf9f9ff'">
            <i class="bi bi-box-fill me-2" style="color:white;"></i>
            {{ config('app.name', 'Laravel') }}
        </a>


        <!-- Mobile Toggle -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                aria-controls="navbarContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <div class="d-flex ms-auto align-items-center">

                <!-- Cart Icon -->
                <!-- <a href="{{ route('customer.cart.index') }}" class="text-decoration-none position-relative me-4 text-dark" style="font-size: 1rem;">
                    <i class="bi bi-cart fs-5"></i>
                    <span class="ms-1">Cart</span>
                    <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ session('cart_count', 0) }}
                    </span>
                </a> -->

                <!-- Authenticated User Dropdown -->
                @auth
                <div class="dropdown">
                    <a href="#" class="text-decoration-none d-flex align-items-center fw-bold text-dark" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-2 fs-5"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
                @endauth

                <!-- Guest Login/Register -->
                @guest
                    @if(Route::has('customer.login'))
                        <a href="{{ route('customer.login') }}" class="btn btn-outline-light ms-3">Login</a>
                    @endif
                    @if(Route::has('customer.register.form'))
                        <a href="{{ route('customer.register.form') }}" class="btn btn-outline-light ms-2">Register</a>
                    @endif
                @endguest
            </div>
        </div>
    </div>
</nav>



        

        <main class="py-4">
        
            @if(Route::is('login') || Route::is('customer.login') || Route::is('customer.register.form'))
                @yield('content')
            @endif
        
        </main>

        
    </div>
    @stack('scripts')
</body>
</html>
