<!-- [ Header Topbar ] start -->
<header class="pc-header">
  <div class="header-wrapper">
    <!-- [Mobile Media Block] start -->
<div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
    <li class="pc-h-item pc-sidebar-collapse">
      <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
        <i class="ph ph-list"></i>
      </a>
    </li>
    <li class="pc-h-item pc-sidebar-popup">
      <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
        <i class="ph ph-list"></i>
      </a>
    </li>
    <li class="dropdown pc-h-item">
      <a
        class="pc-head-link dropdown-toggle arrow-none m-0 trig-drp-search"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <i class="ph ph-magnifying-glass"></i>
      </a>
      <div class="dropdown-menu pc-h-dropdown drp-search">
        <form class="px-3 py-2">
          <input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . ." />
        </form>
      </div>
    </li>
  </ul>
</div>
<!-- [Mobile Media Block end] -->
<div class="ms-auto">
  <ul class="list-unstyled">
    <li class="dropdown pc-h-item">
      <a
        class="pc-head-link dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <i class="ph ph-sun-dim"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
        <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
          <i class="ph ph-moon"></i>
          <span>Dark</span>
        </a>
        <a href="#!" class="dropdown-item" onclick="layout_change('light')">
          <i class="ph ph-sun"></i>
          <span>Light</span>
        </a>
        <a href="#!" class="dropdown-item" onclick="layout_change_default()">
          <i class="ph ph-cpu"></i>
          <span>Default</span>
        </a>
      </div>
    </li>
    <li class="dropdown pc-h-item">
  <a
    class="pc-head-link dropdown-toggle arrow-none me-0"
    data-bs-toggle="dropdown"
    href="#"
    role="button"
    aria-haspopup="false"
    aria-expanded="false"
  >
    <i class="ph ph-user-circle"></i>
  </a>

  <div class="dropdown-menu dropdown-menu-end pc-h-dropdown shadow-sm rounded-3">

    <!-- User Info -->
    <div class="dropdown-header text-center border-bottom py-3">
      <i class="ph ph-user-circle fs-2 d-block mb-1 text-primary"></i>
      <h6 class="mb-0 fw-semibold">
        {{ Auth::user()->name ?? 'Guest User' }}
      </h6>
      <small class="text-muted">
        {{ Auth::user()->email ?? 'No Email Available' }}
      </small>
    </div>

    <div class="dropdown-divider"></div>

    <!-- Dropdown Links -->
    <a href="#!" class="dropdown-item">
      <i class="ph ph-user me-2"></i>
      <span>My Account</span>
    </a>
    

    <div class="dropdown-divider"></div>

    <!-- Logout -->
    <a href="{{ route('logout') }}"
       class="dropdown-item text-danger"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <i class="ph ph-power me-2"></i>
      <span>Logout</span>
    </a>

    <form id="logout-form" action="{{ route('vendor.logout') }}" method="POST" class="d-none">
      @csrf
    </form>
  </div>
</li>

  </ul>
</div>
 </div>
</header>
<!-- [ Header ] end -->
