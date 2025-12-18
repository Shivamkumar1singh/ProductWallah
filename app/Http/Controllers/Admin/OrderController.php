<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrdersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateOrderStatusRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    // Show DataTable page
    public function index(OrdersDataTable $dataTable)
    {
        return $dataTable->render('admin.orders.index');
    }

    // Fetch JSON for DataTables AJAX
    public function getOrdersData(Request $request, OrdersDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    // Show single order details
    public function show(Order $order)
    {
        $order = $this->service->getDetails($order);
        return view('admin.orders.show', compact('order'));
    }

    // Update status
    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $this->service->changeStatus($order, $request->status);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function getStatusCounts()
    {
        $counts = $this->service->getStatusCounts();
        return response()->json($counts);
    }

}
