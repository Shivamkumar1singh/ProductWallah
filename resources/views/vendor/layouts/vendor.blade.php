<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vendor Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('admin/assets/images/shopping-bag.png') }}">
    
    <meta
      name="description"
      content="Admindek - Modern responsive dashboard template built with Bootstrap 5. Features dark/light themes, RTL support, and extensive UI components for admin panels and web applications."
    />
    <meta
      name="keywords"
      content="Admindek - Bootstrap 5 admin template, responsive dashboard, dark mode, RTL support, admin panel, UI components, web application template, modern dashboard"
    />
    <meta name="author" content="DashboardPack.com" />
    <meta name="theme-color" content="#1e293b" />
    <meta name="color-scheme" content="light dark" />

    <!-- [Open Graph] -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Analytics Dashboard | Admindek Dashboard Template" />
    <meta property="og:description" content="Modern responsive dashboard template built with Bootstrap 5. Features dark/light themes, RTL support, and extensive UI components." />
    <meta property="og:site_name" content="Admindek" />

    <!-- [Twitter/X Card] -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Analytics Dashboard | Admindek Dashboard Template" />
    <meta name="twitter:description" content="Modern responsive dashboard template built with Bootstrap 5. Features dark/light themes, RTL support, and extensive UI components." />

    <!-- [FAVICON AND META LINKS] -->

    <!-- <link rel="icon" href="{{ asset('admin/assets/images/favicon.svg') }}"> -->
    <!-- <link rel="apple-touch-icon" href="{{ asset('admin/assets/images/apple-touch-icon.png') }}"> -->
    <!-- <link rel="manifest" href="{{ asset('admin/assets/images/site.webmanifest') }}"> -->

    


    
    <!-- [FONTS AND ICONS] -->

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />

    <!-- Phosphor Icons
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/phosphor-icons.css') }}" />-->

    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.0.3/src/regular/style.css" />


    <!-- Tabler Icons
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/tabler-icons.min.css') }}" />-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">


    <!-- Map Vector CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/plugins/jsvectormap.min.css') }}" />

    <!-- [MAIN TEMPLATE STYLES] -->

    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style-preset.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom-table.css') }}">


    @stack('styles')
    

    </style>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->
    <div class="pc-wrapper">
    <!-- [ADMINDEK SIDEBAR] -->
    @include('vendor.dashboardlayouts.sidebar')

    <!-- [MAIN WRAPPER] -->



        <!-- [HEADER / NAVBAR] -->
        @include('vendor.dashboardlayouts.header')

        <!-- [MAIN CONTENT AREA] -->
        <div class="pc-container">
          <div class="pc-content">
            <!-- @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif -->
              @yield('content')
          </div>
        </div>

        <!-- [CUSTOMIZE BUTTON] -->

        @include('vendor.dashboardlayouts.customizer-button')


        <!-- [FOOTER] -->
        @include('vendor.dashboardlayouts.footer')

    </div>

        <!-- [ JAVASCRIPT FILES ] -->

    <!-- Core Vendor JS -->
    <!--<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.min.js') }}"></script>-->
    <script src="{{ asset('admin/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Charts & Maps (Load only on Dashboard) -->
    @if (Request::is('admin/dashboard'))
        <script src="{{ asset('admin/assets/js/plugins/apexcharts.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/plugins/jsvectormap.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/plugins/world.js') }}"></script>
        <script src="{{ asset('admin/assets/js/widgets/world-low.js') }}"></script>
        <script src="{{ asset('admin/assets/js/widgets/device-chart.js') }}"></script>
        <script src="{{ asset('admin/assets/js/widgets/happy-sad-ball.js') }}"></script>
    @endif

    <!-- i18n and Theme 
    <script src="{{ asset('admin/assets/js/plugins/i18next.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugins/i18nextHttpBackend.min.js') }}"></script>
    
    <script src="{{ asset('admin/assets/js/multi-lang.js') }}"></script>-->
    <script src="{{ asset('admin/assets/js/theme.js') }}"></script>

    <!-- Dashboard Custom Charts (KPI, Revenue, System, Performance, etc.) -->
    
      

    <!-- Theme Config -->
    <script>
      layout_change('light');
      change_box_container('false');
      layout_caption_change('true');
      layout_rtl_change('false');
      preset_change('preset-1');
      layout_theme_sidebar_change('false');
    </script>

    <!-- Main Script -->
    <script src="{{ asset('admin/assets/js/script.js') }}"></script>

    @stack('scripts')

</body>

</html>
