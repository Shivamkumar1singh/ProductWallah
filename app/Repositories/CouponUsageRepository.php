<?php

namespace App\Repositories;

use App\Models\CouponUsage;

class CouponUsageRepository
{
    public function alreadyUsed(int $couponId, int $userId): bool
    {
        return CouponUsage::where('coupon_id', $couponId)
            ->where('user_id', $userId)
            ->exists();
    }

    public function store(array $data): CouponUsage
    {
        return CouponUsage::create($data);
    }

   

}
