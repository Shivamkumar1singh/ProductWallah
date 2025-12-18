<?php

namespace App\Services;

use App\Repositories\CartRepository;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CartService
{
    protected CartRepository $repo;

    public function __construct(CartRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getCartSummary(): array
    {
        $cart = $this->repo->getCartFromSession();
        $total = $this->repo->getGrandTotal($cart);
        $count = $this->repo->getCartCount();
        $this->repo->updateCartCountInSession($count);

        return ['cart' => $cart, 'total' => $total, 'count' => $count];
    }

    public function addProductToCart(int $productId): array
    {
        $product = $this->repo->findProduct($productId);
        if (!$product) return ['error' => 'Product not found!'];

        $cart = $this->repo->getCartFromSession();

        if (isset($cart[$productId])) {
            if ($cart[$productId]['quantity'] >= $product->stock) {
                return ['error' => 'No more stock available!'];
            }
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price'=> $product->price,
                'image'=> $product->image,
                'quantity'=> 1,
                'stock' => $product->stock,
            ];
        }

        $this->repo->saveCart($cart);
        $cartCount = $this->repo->getCartCount();
        $this->repo->updateCartCount($cartCount);

        return ['success' => "{$product->name} added to cart!", 'cart_count' => $cartCount];
    }

    public function updateCartItem(int $id, string $action): array
    {
        $cart = $this->repo->getCartFromSession();
        if (!isset($cart[$id])) return ['error' => 'Item not found in cart!'];

        $product = $this->repo->findProduct($id);
        if (!$product) return ['error' => 'Product does not exist anymore!'];

        if ($action === 'increase') {
            if ($cart[$id]['quantity'] >= $product->stock) return ['error' => "Only {$product->stock} left in stock!"];
            $cart[$id]['quantity']++;
        }

        if ($action === 'decrease') {
            $cart[$id]['quantity']--;
            if ($cart[$id]['quantity'] <= 0) {
                unset($cart[$id]);
                $this->repo->saveCart($cart);
                return [
                    'success' => 'Item removed from cart!',
                    'quantity'=> 0,
                    'cart_count'=> $this->repo->getCartCount(),
                    'grandTotal'=> $this->repo->getGrandTotal($cart),
                ];
            }
        }

        $this->repo->saveCart($cart);
        $itemTotal = $cart[$id]['price'] * $cart[$id]['quantity'];
        $grandTotal = $this->repo->getGrandTotal($cart);
        $cartCount = $this->repo->getCartCount();

        return [
            'success'=> $action === 'increase' ? 'Quantity increased!' : 'Quantity decreased!',
            'quantity'=> $cart[$id]['quantity'],
            'itemTotal'=> $itemTotal,
            'cart_count'=> $cartCount,
            'grandTotal'=> $grandTotal,
        ];
    }

    public function removeCartItem(int $id): array
    {
        $cart = $this->repo->getCartFromSession();
        if (!isset($cart[$id])) return ['error' => 'Item not found in cart!'];

        $cart = $this->repo->removeItem($cart, $id);
        return ['success' => 'Item removed!', 'cart_count' => $this->repo->getCartCount()];
    }

    public function clearCartItems(): array
    {
        $this->repo->clearCart();
        return ['success' => 'Cart cleared!', 'cart_count' => 0];
    }

    public function getCheckoutData(): array
    {
        if ($this->repo->isCartEmpty()) return ['error' => 'Your cart is empty.'];

        $cart = $this->repo->getCartFromSession();
        $total = $this->repo->getGrandTotal($cart);

        return ['cart' => $cart, 'total' => $total];
    }

    public function saveShipping(array $shipping): array
    {
        session(['shipping_details' => $shipping, 'stripe_shipping_backup' => $shipping, 'stripe_cart_backup' => session('cart')]);
        return ['saved' => true];
    }

    public function createStripeSession(int $userId): array
    {
        if ($this->repo->isCartEmpty()) return ['error' => 'Your cart is empty.'];

        $cart = $this->repo->getCartFromSession();
        $shipping = session('shipping_details');

        foreach (['full_name','email','phone','address','city','state','pincode'] as $f) {
            if (empty($shipping[$f])) return ['error' => "Shipping field '{$f}' is missing."];
        }

        $lineItems = [];
        foreach ($cart as $item) {
            $lineItems[] = [
                'price_data'=> ['currency'=>'inr','product_data'=>['name'=>$item['name']],'unit_amount'=>intval($item['price']*100)],
                'quantity'=> $item['quantity'],
            ];
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::create([
                'payment_method_types'=> ['card'],
                'line_items'=> $lineItems,
                'mode'=> 'payment',
                'success_url'=> url('/customer/checkout/success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url'=> url('/customer/checkout/cancel'),
            ]);

            return ['sessionId' => $session->id];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function handlePaymentSuccess(int $userId, array $shipping, array $cart): array
    {
        if (empty($cart)) return ['error' => 'Cart is empty.'];

        foreach (['full_name','email','phone','address','city','state','pincode'] as $f) {
            if (empty($shipping[$f])) return ['error' => "Shipping field '{$f}' is missing."];
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'user_id' => $userId,
            'items' => $cart,
            'total' => $total,
            'payment_status' => 'paid',
            'payment_intent' => null,
            'name'=> $shipping['full_name'],
            'email'=> $shipping['email'],
            'phone'=> $shipping['phone'],
            'address'=> $shipping['address'],
            'city'=> $shipping['city'],
            'state'=> $shipping['state'],
            'pincode'=> $shipping['pincode'],
        ]);

        $this->repo->clearCart();
        session()->forget(['shipping_details', 'stripe_shipping_backup', 'stripe_cart_backup']);

        return ['success' => 'Payment successful!', 'order' => $order];
    }
}
