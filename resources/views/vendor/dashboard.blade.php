@extends('vendor.layouts.vendor')

@section('title', 'Vendor Dashboard')

@section('content')
<!-- [ Main Content ] start -->
    
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
          <div class="page-block">
            <div class="row align-items-center">
              <div class="col-md-12">
                <div class="page-header-title">
                  <h2 class="mb-0">Dashboard</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <h3>Welcome, {{ Auth::guard('vendor')->user()->name }}</h3>
        <!-- [ Main Content ] end -->
      
    <!-- [ Main Content ] end -->
@endsection
