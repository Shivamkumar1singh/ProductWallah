<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\OrderRepository;

class OrderService
{
    protected $repo;

    public function __construct(OrderRepository $repo)
    {
        $this->repo = $repo;
    }

    public function changeStatus(Order $order, string $status)
    {
        return $this->repo->updateStatus($order, $status);
    }

    public function getDetails(Order $order)
    {
        return $this->repo->getOrderDetails($order);
    }

    public function getStatusCounts()
    {
        return $this->repo->getStatusCounts();
    }
}
