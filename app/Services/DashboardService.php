<?php

namespace App\Services;

use App\Repositories\DashboardRepository;

class DashboardService
{
    protected $repo;

    public function __construct(DashboardRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getDashboardData()
    {
        return [
            'total_users'      => $this->repo->countUsers(),
            'total_products'   => $this->repo->countProducts(),
            'total_orders'     => $this->repo->countOrders(),
            // 'total_revenue'    => $this->repo->getTotalRevenue(),
            // 'latest_orders'    => $this->repo->getLatestOrders(),
        ];
    }
}
