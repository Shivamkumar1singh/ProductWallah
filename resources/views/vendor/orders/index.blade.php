@extends('vendor.layouts.vendor')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">
        <i class="ph ph-clipboard-text me-2"></i> Orders List
    </h3>

    <div class="row">
        <div class="col-xxl-8">
            <!-- Existing top cards unchanged -->
            <div class="row g-3 mb-3">
                <!-- TOTAL -->
                <div class="col-md-6 col-lg-4">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="mb-2 d-flex align-items-center justify-content-between gap-1">
                                <h6 class="mb-0">Total</h6>
                                <p class="mb-0 text-muted d-flex align-items-center gap-1">
                                    <i class="ti ti-caret-up-filled text-success"></i>
                                    70.5%
                                </p>
                            </div>
                            <div class="row g-2 align-items-center">
                                <div class="col-6">
                                    <h5 class="mb-2 mt-3">$7,825</h5>
                                    <div class="d-flex align-items-center gap-1">
                                        <h5 class="mb-0">9</h5>
                                        <p class="mb-0 text-muted d-flex align-items-center gap-2">invoices</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div id="total-invoice-1-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PAID -->
                <div class="col-md-6 col-lg-4">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="d-flex mb-2 align-items-center justify-content-between gap-1">
                                <h6 class="mb-0">Paid</h6>
                                <p class="mb-0 text-muted d-flex align-items-center gap-1">
                                    <i class="ti ti-caret-down-filled text-warning"></i>
                                    -8.73%
                                </p>
                            </div>
                            <div class="row g-2 align-items-center">
                                <div class="col-6">
                                    <h5 class="mb-2 mt-3">$5678.09</h5>
                                    <div class="d-flex align-items-center gap-1">
                                        <h5 class="mb-0">5</h5>
                                        <p class="mb-0 text-muted d-flex align-items-center gap-2">invoices</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div id="total-invoice-2-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- OVERDUE -->
                <div class="col-md-12 col-lg-4">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="mb-2 d-flex align-items-center justify-content-between gap-1">
                                <h6 class="mb-0">Overdue</h6>
                                <p class="mb-0 text-muted d-flex align-items-center gap-1">
                                    <i class="ti ti-caret-down-filled text-danger"></i>
                                    -4.73%
                                </p>
                            </div>
                            <div class="row g-2 align-items-center">
                                <div class="col-6">
                                    <h5 class="mb-2 mt-3">$5678.09</h5>
                                    <div class="d-flex align-items-center gap-1">
                                        <h5 class="mb-0">5</h5>
                                        <p class="mb-0 text-muted d-flex align-items-center gap-2">invoices</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div id="total-invoice-3-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- RIGHT SUMMARY CARD -->
        <div class="col-xxl-4">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar bg-white bg-opacity-10 text-white">
                                <i class="ph ph-user-plus f-22"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-white mb-1 d-flex align-items-center gap-2">Total Receivables</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="text-white mb-0">Current <span class="fw-medium f-16">109.1k</span></p>
                                <p class="text-white mb-0">Overdue <span class="fw-medium f-16">62k</span></p>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-white mt-3 mb-1">$43,078</h4>
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 me-3">
                            <div class="progress bg-light-warning" style="height: 7px">
                                <div class="progress-bar bg-warning" style="width: 90%"></div>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end wid-30">
                            <p class="text-white mb-0">90%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ORDERS TABLE -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <!-- FILTER TABS -->
                    <ul class="nav nav-tabs invoice-tab mb-3">
                    
                        <input type="hidden" id="selected_status" value="">
                    
                        <li class="nav-item">
                            <button class="nav-link active order-filter" data-status="">
                                <span class="d-flex align-items-center gap-2">
                                    All
                                    <span class="avatar rounded-circle" id="count-all" style="background-color:#cfe2ff;color:#084298"></span>
                                </span>
                            </button>
                        </li>
                    
                        <li class="nav-item">
                            <button class="nav-link order-filter" data-status="paid">
                                <span class="d-flex align-items-center gap-2">
                                    Paid
                                    <span class="avatar rounded-circle" id="count-paid" style="background-color:#d1e7dd;color:#0f5132;"></span>
                                </span>
                            </button>
                        </li>
                    
                        <li class="nav-item">
                            <button class="nav-link order-filter" data-status="processing">
                                <span class="d-flex align-items-center gap-2">
                                    Processing
                                    <span class="avatar rounded-circle" id="count-processing" style="background-color:#cff4fc;color:#055160;"></span>
                                </span>
                            </button>
                        </li>
                    
                        <li class="nav-item">
                            <button class="nav-link order-filter" data-status="delivered">
                                <span class="d-flex align-items-center gap-2">
                                    Delivered
                                    <span class="avatar rounded-circle" id="count-delivered" style="background-color:#d1e7dd;color:#0f5132;"></span>
                                </span>
                            </button>
                        </li>
                    
                        <li class="nav-item">
                            <button class="nav-link order-filter" data-status="cancelled">
                                <span class="d-flex align-items-center gap-2">
                                    Cancelled
                                    <span class="avatar rounded-circle" id="count-cancelled" style="background-color:#f8d7da;color:#842029;"></span>
                                </span>
                            </button>
                        </li>
                    </ul>
                    

                    <!-- DATATABLE -->
                    <div class="table-responsive">
                        <table class="table table-hover" id="pc-dt-simple-1">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Payment Status</th>
                                    <th>Order Status</th>
                                    <th>Order Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
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

let table;

// Load counts
function loadCounts() {
    $.get("{{ route('vendor.orders.counts') }}", function(data) {
        $("#count-all").text(data.all);
        $("#count-paid").text(data.paid);
        $("#count-processing").text(data.processing);
        $("#count-delivered").text(data.delivered);
        $("#count-cancelled").text(data.cancelled);
    });
}

$(function () {

    // Init DataTable
    table = $('#pc-dt-simple-1').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('vendor.orders.data') }}",
            data: function(d){
                d.status = $("#selected_status").val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'customer' },
            { data: 'total' },
            { data: 'payment_status', orderable: false },
            { data: 'status', orderable: false },
            { data: 'created_at' },
            { data: 'actions', orderable: false, searchable: false }
        ]
    });

    loadCounts();

    // Filter tab click
    $(".order-filter").on("click", function(){
        $(".order-filter").removeClass("active");
        $(this).addClass("active");

        $("#selected_status").val($(this).data("status"));
        table.ajax.reload();

        loadCounts();
    });
});

// Update Status
$(document).on('click', '.update-status', function() {
    let id = $(this).data('id');
    let newStatus = prompt("New status:");

    if(!newStatus) return;

    $.ajax({
        url: "/admin/orders/" + id + "/status",
        type: "PUT",
        data: {
            status: newStatus,
            _token: "{{ csrf_token() }}"
        },
        success: function(){
            table.ajax.reload();
            loadCounts();
        }
    });
});

</script>
@endpush
