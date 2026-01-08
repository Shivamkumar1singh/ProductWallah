<?php

namespace App\Repositories;

use App\Models\Products;

class CartRepository
{
    public function getCartFromSession(): array
    {
        return session()->get('cart', []);
    }

    public function saveCart(array $cart): void
    {
        session(['cart' => $cart]);
    }

    public function removeItem(array $cart, int $id): array
    {
        unset($cart[$id]);
        $this->saveCart($cart);
        return $cart;
    }

    public function clearCart(): void
    {
        session()->forget('cart');
        session(['cart_count' => 0]);
    }

    public function updateCartCountInSession(int $count): void
    {
        session(['cart_count' => $count]);
    }

    public function updateCartCount(int $count): void
    {
        session(['cart_count' => $count]);
    }

    public function getCartCount(): int
    {
        return collect(session('cart', []))->sum('quantity');
    }

    public function getGrandTotal(array $cart): float
    {
        return collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    public function findProduct(int $id)
    {
        return Products::find($id);
    }

    public function isCartEmpty(): bool
    {
        return empty($this->getCartFromSession());
    }

    public function getDiscountedTotal(array $cart): float
    {
        $total = $this->getGrandTotal($cart);
        $coupon = session('applied_coupon');
    
        if (
            !is_array($coupon) ||
            empty($coupon['discount'])
        ) {
            return $total;
        }
    
        return max(0, $total - $coupon['discount']);
    }

}
