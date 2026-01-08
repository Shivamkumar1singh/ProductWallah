@extends('layouts.admin.master')

@section('title', 'Coupons Details')
@section('content')
<div class="container mt-4">

    {{-- PAGE TITLE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="ph ph-clipboard-text me-2"></i> Coupons List
        </h3>
    
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
            Add New Coupon
        </a>
    </div>


    {{-- TOP SUMMARY CARDS --}}
    <div class="row g-3 mb-4">

    <div class="col-md-6 col-lg-4">
        <div class="card border-0 mb-0" style="background:#e7f1ff">
            <div class="card-body">
                <h6>Total Coupons</h6>
                <h4 class="text-primary">{{ $stats['total'] }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card border-0 mb-0" style="background:#e8f7ee">
            <div class="card-body">
                <h6>Active</h6>
                <h4 class="text-success">{{ $stats['active'] }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-4">
        <div class="card border-0 mb-0" style="background:#fdecea">
            <div class="card-body">
                <h6>Inactive</h6>
                <h4 class="text-danger">{{ $stats['inactive'] }}</h4>
            </div>
        </div>
    </div>

</div>


    {{-- MAIN CARD --}}
    <div class="card">
        <div class="card-body">

            

            <!-- FILTER TABS -->
            <ul class="nav nav-tabs invoice-tab mb-3">
            
                <input type="hidden" id="selected_status" value="">
            
                <!-- ALL -->
                <li class="nav-item">
                    <button class="nav-link active coupon-filter" data-status="">
                        <span class="d-flex align-items-center gap-2">
                            All
                            <span class="avatar rounded-circle"
                                  id="count-all"
                                  style="background-color:#cfe2ff;color:#084298">
                                  {{ $stats['total'] }}
                            </span>
                        </span>
                    </button>
                </li>
            
                <!-- ACTIVE -->
                <li class="nav-item">
                    <button class="nav-link coupon-filter" data-status="active">
                        <span class="d-flex align-items-center gap-2">
                            Active
                            <span class="avatar rounded-circle"
                                  id="count-active"
                                  style="background-color:#d1e7dd;color:#0f5132;">
                                  {{ $stats['active'] }}
                            </span>
                        </span>
                    </button>
                </li>
            
                <!-- INACTIVE -->
                <li class="nav-item">
                    <button class="nav-link coupon-filter" data-status="inactive">
                        <span class="d-flex align-items-center gap-2">
                            Inactive
                            <span class="avatar rounded-circle"
                                  id="count-inactive"
                                  style="background-color:#f8d7da;color:#842029;">
                                  {{ $stats['inactive'] }}
                            </span>
                        </span>
                    </button>
                </li>
            
            </ul>
            

            {{-- DATATABLE (NO tbody, NO foreach) --}}
            <div class="table-responsive">
                <table class="table table-hover" id="couponTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Used</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>

            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')

{{-- jQuery required --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Yajra DataTables --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>

<script>
let couponTable;

$(function () {

    couponTable = $('#couponTable').DataTable({
        processing: true,
        serverSide: true,
        
        ajax: {
            url: "{{ route('admin.coupons.data') }}",
            data: function (d) {
                d.status = $('#selected_status').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'code' },
            { data: 'type' },
            { data: 'value' },
            { data: 'used_count' },
            { data: 'status', orderable: false },
            { data: 'actions', orderable: false, searchable: false }
        ]
    });

    // SINGLE click handler
    $('.coupon-filter').on('click', function (e) {
        e.preventDefault(); // stop page reload

        $('.coupon-filter').removeClass('active');
        $(this).addClass('active');

        $('#selected_status').val($(this).data('status'));

        // Reload DataTable safely
        $('#couponTable').DataTable().ajax.reload();
    });

});
</script>

@endpush

