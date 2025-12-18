<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Show all orders of logged in customer
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->latest()
                       ->get();

        return view('customer.orders.index', compact('orders'));
    }

    // Show single order details
    public function show(Order $order)
    {
        // security → customer cannot view others orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->items = is_string($order->items)
            ? json_decode($order->items, true)
            : $order->items;

        return view('customer.orders.show', compact('order'));
    }
}
