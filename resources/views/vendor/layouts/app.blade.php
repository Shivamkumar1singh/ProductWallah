<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vendor Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('admin/assets/images/shopping-bag.png') }}">
    <!-- Bootstrap CSS (5.3.3) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    

</head>
<body class="bg-light">

    {{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand fw-bold d-flex align-items-center"
           href=""
           style="
               color:#000;
               font-weight:700;
               font-family: 'Poppins', sans-serif;
               font-size: 1.25rem;      /* adjust if needed */
               line-height: 1.2;        /* keeps height consistent */
           "
           onmouseover="this.style.color='#111'"
           onmouseout="this.style.color='#000'">
            <img src="{{ asset('admin/assets/images/shopping-bag.png') }}"
             alt="Logo"
             width="24"
             height="24"
             class="me-2"
             style="object-fit: contain;">
            {{ config('app.name', 'Laravel') }}
        </a>

        



        <div class="d-flex align-items-center ms-auto">
    

    <!-- Simple Customer Name Dropdown -->
    @auth
    <div class="dropdown">
        <a href="#" class="text-decoration-none d-flex align-items-center fw-bold text-dark" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle me-2" style="font-size: 1.3rem;"></i>
            <span>{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
    
            <li>
                <a class="dropdown-item text-danger" href="" id="vendorLogout">
                    Logout
                </a>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('vendor.logout') }}" method="POST" class="d-none">
            @csrf
        </form>

    </div>
    @endauth

    @guest
    <a href="{{ route('vendor.login') }}" class="ms-3 text-dark text-decoration-none">Login</a>
    <a href="{{ route('vendor.register') }}" class="ms-3 text-dark text-decoration-none">Register</a>
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
        $(document).on('click', '#vendorLogout', function(e) {
            e.preventDefault();
        
            $.ajax({
                url: "{{ route('vendor.logout') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // Redirect to login page after successful logout
                    window.location.href = "{{ route('vendor.login') }}";
                },
                error: function(xhr) {
                    console.error("Logout Error:", xhr.responseText);
                }
            });
        });
    </script>
</body>
</html>
