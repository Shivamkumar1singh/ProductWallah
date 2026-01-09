<?php

namespace App\Services;

use App\Repositories\CartRepository;
use App\Models\Order;
use App\Models\Products;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use App\Services\CouponService;

class CartService
{
    protected CartRepository $repo;
    protected OrderService $orderService;

    public function __construct(CartRepository $repo, OrderService $orderService)
    {
        $this->repo = $repo;
        $this->orderService = $orderService;
    }

    public function getCartSummary(): array
    {
        $cart = $this->repo->getCartFromSession();
        $subtotal = $this->repo->getGrandTotal($cart);
        $payable  = $this->repo->getDiscountedTotal($cart);

        $count = $this->repo->getCartCount();
        $this->repo->updateCartCountInSession($count);

        return ['cart' => $cart, 'subtotal' => $subtotal, 'payable' => $payable, 'count' => $count];
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
                'product_id' => $product->id,
                'vendor_id'  => $product->vendor_id,
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
        $subtotal = $this->repo->getGrandTotal($cart);
        $discount = session('applied_coupon.discount', 0);
        $payable = max(0, $subtotal - $discount);

        return [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'payable' => $payable,
        ];
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
            if (empty($shipping[$f])) {
                return ['error' => "Shipping field '{$f}' is missing."];
            }
        }



        $payable = max(1,$this->repo->getDiscountedTotal($cart));

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => ['name' => 'Order Payment'],
                    'unit_amount' => (int) round($payable * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/customer/checkout/success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/customer/checkout/cancel'),
            ]);

        return ['sessionId' => $session->id];
    }

    public function handlePaymentSuccess(int $userId, array $shipping, array $cart, string $paymentIntent): array
    {
        if (empty($cart)) {
            return ['error' => 'Cart is empty.'];
        }
    
        foreach (['full_name','email','phone','address','city','state','pincode'] as $f) {
            if (empty($shipping[$f])) {
                return ['error' => "Shipping field '{$f}' is missing."];
            }
        }

        $subtotal = $this->repo->getGrandTotal($cart);
        
        $coupon = session('applied_coupon');
        
        $discount = $coupon['discount'] ?? 0;
        $couponCode = $coupon['code'] ?? null;

        $total = max(0, $subtotal - $discount);

        $order = null;
        

        DB::transaction(function () use (
        $userId,
        $shipping,
        $cart,
        $subtotal,
        $discount,
        $couponCode,
        $total,
        $paymentIntent,
        &$order
    ) {
        $order = Order::create([
            'user_id' => $userId,
            'items' => $cart,
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'coupon_code' => $couponCode,
            'total' => $total,
            'payment_status' => 'paid',
            'payment_intent' => $paymentIntent,
            'name'=> $shipping['full_name'],
            'email'=> $shipping['email'],
            'phone'=> $shipping['phone'],
            'address'=> $shipping['address'],
            'city'=> $shipping['city'],
            'state'=> $shipping['state'],
            'pincode'=> $shipping['pincode'],
        ]);

        foreach ($cart as $item) {

            
            $product = Products::select('id', 'vendor_id')
                ->findOrFail($item['product_id']);
        
            
            if (!$product->vendor_id) {
                throw new \Exception("Vendor missing for product ID: {$product->id}");
            }

           
            $order->products()->attach($item['product_id'], [
                'vendor_id' => $product->vendor_id,
                'quantity'  => $item['quantity'],
                'price'     => $item['price'],
            ]);
        }

        app(\App\Services\CouponService::class)
           ->finalizeCouponUsage($order->id, $userId);

    });
        
        $this->orderService->sendVendorOrderEmail($order);

        $this->repo->clearCart();
        session()->forget(['applied_coupon','shipping_details', 'stripe_shipping_backup', 'stripe_cart_backup']);

        return ['success' => 'Payment successful!', 'order' => $order];
    }
}
