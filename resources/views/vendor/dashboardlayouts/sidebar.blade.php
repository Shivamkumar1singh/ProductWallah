 <!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="{{ route('vendor.dashboard') }}" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img src="{{ asset('admin/assets/images/download.svg') }}" class="img-fluids logo-lg" alt="logo" />
      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-item pc-caption">
          <label data-i18n="Navigation">Navigation</label>
        </li>
        <li class="pc-item ">
          <a href="{{ route('vendor.dashboard') }}" class="pc-link">
            <span class="pc-micon">
              <i class="ph ph-house-line"></i>
            </span>
            <span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
          </a>
        
        </li>


        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link">
            <span class="pc-micon">
              <i class="ph ph-shopping-cart-simple"></i>
            </span>
            <span class="pc-mtext" data-i18n="product_management">Product Management</span>
            <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
          </a>
        
          <ul class="pc-submenu">
            <li class="pc-item">
              <a class="pc-link" href="#" data-i18n="product_list">
                <i class="ph ph-package me-2"></i> Product List
              </a>
            </li>
            
            <li class="pc-item">
              <a class="pc-link" href="#" data-i18n="cart_list">
                <i class="ph ph-squares-four me-2"></i> Categories
              </a>
            </li>
          </ul>
        </li>
        
      </ul>
    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end -->
