<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Order;
use App\Models\Products;

class DashboardRepository
{
    public function countUsers()
    {
        return User::count();
    }

    public function countProducts()
    {
        return Products::count();
    }

    public function countOrders()
    {
        return Order::count();
    }

    public function getTotalRevenue()
    {
        //return Order::sum('total_amount');
    }

    public function getLatestOrders($limit = 5)
    {
        //return Order::latest()->take($limit)->get();
    }
}
