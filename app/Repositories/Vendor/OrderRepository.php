<?php

namespace App\Repositories\Vendor;

use App\Models\Order;

class OrderRepository
{
    // Fetch orders for the logged-in vendor
    public function getOrdersQuery()
    {
        $vendorId = auth('vendor')->id();

        $query = Order::with('user')
    ->whereHas('products', function ($q) use ($vendorId) {
        $q->where('order_product.vendor_id', $vendorId);
    })
    ->with(['products' => function ($q) use ($vendorId) {
        $q->where('order_product.vendor_id', $vendorId);
    }])
    ->latest();



        // Apply optional status filter
        if (request()->filled('status')) {
            if (request()->status === 'paid') {
                $query->where('payment_status', 'paid');
            } else {
                $query->where('status', request()->status);
            }
        }

        return $query;
    }

    // Get counts of orders per status for the vendor
    public function getStatusCounts()
    {
        $vendorId = auth('vendor')->id();

        $base = Order::whereHas('products', function ($q) use ($vendorId) {
    $q->where('order_product.vendor_id', $vendorId);
});


        return [
            'all'        => (clone $base)->count(),
            'paid'       => (clone $base)->where('payment_status', 'paid')->count(),
            'processing' => (clone $base)->where('status', 'processing')->count(),
            'delivered'  => (clone $base)->where('status', 'delivered')->count(),
            'cancelled'  => (clone $base)->where('status', 'cancelled')->count(),
        ];
    }

    // Update order status
    public function updateStatus(Order $order, string $status)
    {
        return $order->update(['status' => $status]);
    }

    // Decode JSON items
    public function getOrderDetails(Order $order)
    {
        if (is_string($order->items)) {
            $order->items = json_decode($order->items, true);
        }
        return $order;
    }
}
