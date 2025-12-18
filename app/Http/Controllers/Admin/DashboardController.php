<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->middleware('auth');
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        // Controller only calls service
        $data = $this->dashboardService->getDashboardData();

        return view('admin.dashboard', compact('data'));
    }
}
