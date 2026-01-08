<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Requests\Cart\CartAddRequest;
use App\Http\Requests\Cart\CartUpdateRequest;
use App\Http\Requests\Cart\SaveShippingRequest;
use App\Services\CouponService;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CartController extends Controller
{
    protected CartService $service;
    protected CouponService $couponService;

    public function __construct(CartService $service, CouponService $couponService)
    {
        $this->service = $service;
        $this->couponService = $couponService;
        $this->middleware('auth');
    }

    public function index()
    {
        $summary = $this->service->getCartSummary();
        return view('customer.cart.index', $summary);
    }

    public function add(CartAddRequest $request, $id)
    {
        $result = $this->service->addProductToCart($id);

        if (isset($result['error'])) {
            return $request->ajax()
                ? response()->json(['error' => $result['error']])
                : back()->with('error', $result['error']);
        }

        return $request->ajax()
            ? response()->json($result)
            : back()->with('success', $result['success']);
    }

    public function update(CartUpdateRequest $request)
    {
        $result = $this->service->updateCartItem($request->id, $request->action);

        return isset($result['error'])
            ? response()->json(['error' => $result['error']])
            : response()->json($result);
    }

    public function remove(Request $request, $id)
    {
        $result = $this->service->removeCartItem($id);

        if (isset($result['error'])) {
            return $request->ajax()
                ? response()->json(['error' => $result['error']])
                : back()->with('error', $result['error']);
        }

        return $request->ajax()
            ? response()->json($result)
            : back()->with('success', $result['success']);
    }

    public function clear()
    {
        $result = $this->service->clearCartItems();
        return back()->with('success', $result['success']);
    }

    public function checkout()
    {
        $data = $this->service->getCheckoutData();

        if (isset($data['error'])) {
            return redirect()->route('customer.cart.index')->with('error', $data['error']);
        }

        $data['coupons'] = $this->couponService->getAvailableCouponsForCustomer(auth()->id());

        return view('customer.checkout', $data);
    }

    public function saveShipping(SaveShippingRequest $request)
    {
        $result = $this->service->saveShipping($request->validated()['shipping']);
        return response()->json($result);
    }

    public function createStripePayment(Request $request)
    {
        $userId = auth()->id();
        $result = $this->service->createStripeSession($userId);

        return isset($result['error'])
            ? response()->json(['error' => $result['error']])
            : response()->json(['sessionId' => $result['sessionId']]);
    }

    public function paymentSuccess(Request $request)
    {
        $sessionId = $request->query('session_id');
        if (!$sessionId) return redirect()->route('shop.index')->with('error', 'Invalid payment session.');

        Stripe::setApiKey(config('services.stripe.secret'));
        $stripeSession = StripeSession::retrieve($sessionId);

        if (!$stripeSession || $stripeSession->payment_status != 'paid') {
            return redirect()->route('shop.index')->with('error', 'Payment not completed.');
        }

        $shipping = session('stripe_shipping_backup');
        $cart     = session('stripe_cart_backup');

        if (!$shipping || !$cart) {
            return redirect()->route('customer.cart.index')->with('error', 'Shipping or cart data missing.');
        }

        $result = $this->service->handlePaymentSuccess(auth()->id(), $shipping, $cart,$stripeSession->payment_intent);
        

        if (isset($result['error'])) {
            return redirect()->route('shop.index')->with('error', $result['error']);
        }

        


        return view('customer.checkout.success', ['order' => $result['order']]);
    }
}
