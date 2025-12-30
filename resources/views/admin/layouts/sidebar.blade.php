 <!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="{{ route('admin.dashboard') }}" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img src="{{ asset('admin/assets/images/logo-white.svg') }}" class="img-fluids logo-lg" alt="logo" />
      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-item pc-caption">
          <label data-i18n="Navigation">Navigation</label>
        </li>
        <li class="pc-item ">
          <a href="{{ route('admin.dashboard') }}" class="pc-link">
            <span class="pc-micon">
              <i class="ph ph-house-line"></i>
            </span>
            <span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
          </a>
        
        </li>

        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link">
            <span class="pc-micon">
              <i class="ph ph-user-gear"></i>
            </span>
            <span class="pc-mtext" data-i18n="user_management">User Management</span>
            <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item">
              <a class="pc-link" href="{{ route('admin.roles.index')}}" data-i18n="role_menu">
                <i class="ph ph-shield-check me-2"></i> Role
              </a>
            </li>
            <li class="pc-item">
              <a class="pc-link" href="{{ route('admin.users.index') }}" data-i18n="user_menu">
                <i class="ph ph-user-circle me-2"></i> User
              </a>
            </li>
          </ul>
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
              <a class="pc-link" href="{{ route('admin.productManagement.product.index') }}" data-i18n="product_list">
                <i class="ph ph-package me-2"></i> Product List
              </a>
            </li>
            
            <li class="pc-item">
              <a class="pc-link" href="{{ route('admin.productManagement.categories.index') }}" data-i18n="cart_list">
                <i class="ph ph-squares-four me-2"></i> Categories
              </a>
            </li>
          </ul>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link">
            <span class="pc-micon">
              <i class="ph ph-clipboard-text me-2"></i>
            </span>
            <span class="pc-mtext" >Order Details</span>
            <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
          </a>
        
          <ul class="pc-submenu">
            <li class="pc-item">
              <a class="pc-link" href="{{ route('admin.orders.index') }}" data-i18n="product_list">
                <i class="ph ph-shopping-bag me-2"></i> Order
              </a>
            </li>
          </ul>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link">
            <span class="pc-micon">
              <i class="ph ph-ticket me-2"></i>
            </span>
            <span class="pc-mtext" >Coupons and Vouchers</span>
            <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
          </a>
        
          <ul class="pc-submenu">
            <li class="pc-item">
              <a class="pc-link" href="#" data-i18n="product_list">
                <i class="ph ph-percent me-2"></i> Coupons
              </a>
            </li>
            <li class="pc-item">
              <a class="pc-link" href="#" data-i18n="product_list">
                <i class="ph ph-gift me-2"></i> Vouchers
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end -->
