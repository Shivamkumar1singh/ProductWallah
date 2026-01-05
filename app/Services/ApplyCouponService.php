<?php

namespace App\Services;

use App\Repositories\CouponRepository;
use App\Repositories\CouponUsageRepository;
use Illuminate\Support\Facades\DB;


class ApplyCouponService
{
    protected CouponRepository $couponRepository;
    protected CouponUsageRepository $couponUsageRepository;

    public function __construct(CouponRepository $couponRepository, CouponUsageRepository $couponUsageRepository)
    {
        $this->couponRepository = $couponRepository;
        $this->couponUsageRepository = $couponUsageRepository;
    }

    public function apply(string $code, float $orderTotal, int $userId): array
    {
        $coupon = $this->couponRepository->findActiveByCode($code);

        if (! $coupon){
            return $this->fail('Invalid coupon code');
        }

        if (! $coupon->isValid()) {
            return $this->fail('Coupon is expired or inactive');
        }

        if ($coupon->min_order_amount && $orderTotal < $coupon->min_order_amount) {
            return $this->fail('Minimum order amount not met');
        }

        if ($this->couponUsageRepository->alreadyUsed($coupon->id, $userId)) {
            return $this->fail('You have already used this coupon');
        }

        $discount = $coupon->type === 'percentage'
            ? ($orderTotal * $coupon->value / 100)
            : $coupon->value;

        $discount = min($discount, $orderTotal);

        // Store in session 
        session()->put('applied_coupon', [
            'coupon_id' => $coupon->id,
            'code' => $coupon->code,
            'discount' => round($discount,2),
        ]);

        return [
            'success' => true,
            'message' => 'Coupon applied successfully',
            'data' => [
                'coupon_code' => $coupon->code,
                'discount' => round($discount,2),
                'payable' => round($orderTotal - $discount,2),
            ],
        ];
    }

    private function fail(string $message): array
    {
        return [
            'success' => false,
            'message' => $message,
            'data' => null,
        ];
    }
}