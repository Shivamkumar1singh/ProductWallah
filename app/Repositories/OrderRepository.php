<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function getOrdersQuery()
{
    $query = Order::with('user')->latest();

    // Order Status filter (processing, delivered, cancelled)
    if (request()->filled('status')) {

        // If "paid" tab clicked → filter payment_status
        if (request()->status === 'paid') {
            $query->where('payment_status', 'paid');
        } 
        // Otherwise → order status
        else {
            $query->where('status', request()->status);
        }
    }

    return $query;
}


    public function updateStatus(Order $order, string $status)
    {
        return $order->update(['status' => $status]);
    }

    public function getOrderDetails(Order $order)
    {
        if (is_string($order->items)) {
            $order->items = json_decode($order->items, true);
        }
        return $order;
    }

    public function getStatusCounts()
    {
        return [
            'all'        => Order::count(),
            'paid'       => Order::where('payment_status', 'paid')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'delivered'  => Order::where('status', 'delivered')->count(),
            'cancelled'  => Order::where('status', 'cancelled')->count(),
        ];
    }
}
