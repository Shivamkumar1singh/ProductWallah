<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\StoreCouponRequest;
use App\Http\Requests\Coupon\UpdateCouponRequest;
use App\Services\CouponService;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use App\Datatables\CouponDataTable;

class CouponController extends Controller
{
    protected CouponService $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function index(CouponDataTable $dataTable)
    {
        return $dataTable->render('admin.coupons.index', [
            'stats' => [
                'total' => Coupon::count(),
                'active' => Coupon::where('is_active', 1)->count(),
                'inactive' => Coupon::where('is_active', 0)->count(),
            ]
        ]);
    }

    public function data(CouponDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    // show form to create a new coupon

    public function create()
    {
        return view('admin.coupons.create');
    }

    // Store a new coupon

    public function store(StoreCouponRequest $request): RedirectResponse
    {
        $this->couponService->createCoupon($request->validated());

        return Redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully');
    }

    public function toggle(Coupon $coupon): RedirectResponse
    {
        $this->couponService->toggleStatus($coupon);

        return redirect()->back()->with('success', 'Coupon status updated successfully');
    }

    // public function show(Coupon $coupon)
    // {
    //     return view('admin.coupons.show', compact('coupon'));
    // }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }
    
    public function update(UpdateCouponRequest $request, Coupon $coupon): RedirectResponse 
    {
        $this->couponService->updateCoupon($coupon, $request->validated());
    
        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully');
    }

    public function destroy(Coupon $coupon): RedirectResponse
    {
        $this->couponService->deleteCoupon($coupon);

        return redirect()->route('admin.coupons.index')
             ->with('success', 'Coupon deleted successfully');
    }
}
