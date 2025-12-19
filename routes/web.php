<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ProductManagement\Categories\CartController;
use App\Http\Controllers\ProductManagement\Categories\ProductsController;
use App\Http\Controllers\ProductManagement\Categories\CategoryController;
use App\Http\Controllers\Customer\ShopController;
use App\Http\Controllers\Customer\CartController as CustomerCartController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Datatables\OrdersDataTable;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route::get('/', function () { 
//     if (auth()->check()) {
//         return redirect()->route('admin.dashboard');
//     }
    
//     return redirect()->route('login');
// });

Route::get('/', function() {
    // If customer is logged in, go to shop
    if (auth('web')->check()) {
        return redirect()->route('shop.index');
    }

    // default page is customer login
    return redirect()->route('shop.index');
});


// Authentication routes
//Auth::routes();


// Disable default Laravel login 
Auth::routes(['login' => false, 'register' => false,]);


Route::get('/login', function () {
    if (auth('web')->check()) {
        if (auth('web')->user()->hasRole('admin')){
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('shop.index');
        }
    }
    return view('auth.login');
})->name('login');

Route::get('/customer/login', function() {
    if(auth('web')->check()) {
        //return redirect()->route('customer.dashboard');
        return redirect()->route('shop.index');
    }
    return view('auth.customer_login');
})->name('customer.login');

// ---------------------------
// CUSTOMER REGISTER ROUTES
// ---------------------------
// Route::get('/customer/register', function () {
//     return view('auth.customer_register');
// })->name('customer.register');

// Route::post('/customer/register', [CustomerLoginController::class, 'register'])
//     ->name('customer.register');


Route::get('/customer/register', [RegisterController::class, 'showRegistrationForm'])->name('customer.register.form');
Route::post('/customer/register', [RegisterController::class, 'register'])->name('customer.register');

Route::get('/admin/register', [RegisterController::class, 'showRegistrationForm'])->name('admin.register.form');
Route::post('/admin/register', [RegisterController::class, 'register'])->name('admin.register');


// Admin Login Submission
Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit');

// Customer Login Submission
Route::post('/customer/login', [CustomerLoginController::class, 'customerLogin'])->name('customer.login.submit');

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');


Route::get('/shop/category/{category}', [ShopController::class, 'category'])
    ->name('shop.category');

// Customer Routes
Route::middleware(['auth'])->group(function () {

    // Shop page (for customers)
    // Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

    // Customer Cart Routes
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/cart', [CustomerCartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{id}', [CustomerCartController::class, 'add'])->name('cart.add');
        Route::post('/cart/update', [CustomerCartController::class, 'update'])->name('cart.update');
        Route::post('/cart/remove/{id}', [CustomerCartController::class, 'remove'])->name('cart.remove');
        Route::get('/checkout', [CustomerCartController::class, 'checkout'])->name('checkout');
        // Save Shipping Details Before Payment
        Route::post('/checkout/save-shipping', [CustomerCartController::class, 'saveShipping'])
            ->name('checkout.save.shipping');
    
        Route::post('/checkout/stripe', [CustomerCartController::class, 'createStripePayment'])->name('checkout.stripe');
        Route::get('/checkout/success', [CustomerCartController::class, 'paymentSuccess'])->name('checkout.success');
        // Route::get('/checkout/success', function () {
        //     return view('customer.checkout.success');
        // })->name('checkout.success');
        
        Route::get('/checkout/cancel', function () {
            return redirect()->route('customer.cart.index')
                ->with('error', 'Payment was cancelled.');
        })->name('checkout.cancel');


        // Customer Orders
        Route::get('/orders', [CustomerOrderController::class, 'index'])
            ->name('orders.index');
        
        Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])
            ->name('orders.show');
        

    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // User Management
        Route::resource('users', UserController::class);

        // Role Management
        Route::resource('roles', RoleController::class);

        // // Product Management
        // Route::resource('products', ProductController::class);

        // Order Management (NEW)
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/data', [OrderController::class, 'getOrdersData'])->name('orders.data');
         Route::get('/orders/counts', [OrderController::class, 'getStatusCounts'])->name('orders.counts');
        //Route::get('/orders/list', [OrderController::class, 'getOrders'])->name('orders.list');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
       


        Route::prefix('productManagement')
            ->name('productManagement.')
            ->group(function () {
       
        
                // Category Management
                Route::resource('categories', CategoryController::class);

                // Product Management
                Route::resource('product', ProductsController::class);
                
                });
            });


 
        
        
// Include custom routes
require __DIR__.'/vendor.php';






