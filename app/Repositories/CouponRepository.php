<?php

namespace App\Repositories;

use App\Models\Coupon;

class CouponRepository

{
    public function getAll()
    {
        return Coupon::latest()->get();
    }

    public function create(array $data): Coupon
    {
        return Coupon::create($data);
    }

    public function update(Coupon $coupon, array $data): bool
    {
        return $coupon->update($data);
    }

    public function findActiveByCode(string $code): ?Coupon
    {
        
        return Coupon::where('code', $code)
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            })
            ->first();

    }

    public function getAvailableForUser(int $userId)
    {
        return Coupon::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            })
            ->whereDoesntHave('usages', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->get();
    }


    public function delete(Coupon $coupon): bool
    {
        return $coupon->delete();
    }
}
