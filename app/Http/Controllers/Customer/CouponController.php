<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected CouponService $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->middleware('auth');
        $this->couponService = $couponService;
    }

    public function index()
    {
        $coupons = $this->couponService->getAvailableCouponsForCustomer(auth()->id());

        return view('customer.coupons.index', compact('coupons'));
    }
}
