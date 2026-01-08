<?php

namespace App\Services;

use App\Models\Coupon;
use App\Repositories\CouponRepository;
use App\Repositories\CouponUsageRepository;

class CouponService
{
    protected CouponRepository $couponRepository;
    protected CouponUsageRepository $couponUsageRepository;

    public function __construct(CouponRepository $couponRepository, CouponUsageRepository $couponUsageRepository)
    {
        $this->couponRepository = $couponRepository;
        $this->couponUsageRepository = $couponUsageRepository;
    }

    // Methods for the admin panel 

    public function getAllCoupons()
    {
        return $this->couponRepository->getAll();
    }

    public function createCoupon(array $data): Coupon
    {
        
        if (empty($data['usage_limit'])) {
            $data['usage_limit'] = null;
        }
    
        return $this->couponRepository->create($data);
    }


    public function updateCoupon(Coupon $coupon, array $data): void
    {
        $this->couponRepository->update($coupon, $data);
    }

    public function toggleStatus(Coupon $coupon): void
    {
        $this->couponRepository->update($coupon, [
            'is_active' => ! $coupon->is_active
        ]);
    }

    // Method for the customer
    public function finalizeCouponUsage(int $orderId, int $userId): void
    {
        if (! session()->has('applied_coupon')) {
            return;
        }
    
        $couponData = session('applied_coupon');
    
        $this->couponUsageRepository->store([
            'coupon_id' => $couponData['coupon_id'],
            'user_id'   => $userId,
            'order_id'  => $orderId,
        ]);

    
        $coupon = Coupon::find($couponData['coupon_id']);
        $coupon->increment('used_count');
    
        session()->forget('applied_coupon');
    }

    public function deleteCoupon(Coupon $coupon): void 
    {
        if($coupon->used_count >0) {
            abort(403, 'Used coupons cannot be deleted.');
        }

        $this->couponRepository->delete($coupon);
    }

    public function getAvailableCouponsForCustomer(int $userId)
    {
        return $this->couponRepository->getAvailableForUser($userId);
    }


}
