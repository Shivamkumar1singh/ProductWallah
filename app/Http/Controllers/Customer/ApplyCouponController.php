<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\ApplyCouponRequest;
use App\Services\CouponService;
use App\Services\ApplyCouponService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApplyCouponController extends Controller
{
    protected ApplyCouponService $applyCouponService;

    public function __construct(ApplyCouponService $applyCouponService)
    {
        $this->applyCouponService = $applyCouponService;
    }
    
    public function apply(ApplyCouponRequest $request)
    {
        $response = $this->applyCouponService->apply(
            $request->coupon_code,
            $request->order_total,
            auth()->id()
        );
    
        return response()->json($response, $response['success'] ? 200 : 422);
    }

    public function remove(): JsonResponse
    {
        session()->forget('applied_coupon');
    
        return response()->json([
            'success' => true,
            'message' => 'Coupon removed successfully'
        ]);
    }

}
