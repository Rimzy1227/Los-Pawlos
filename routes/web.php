<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminSettingsController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove', [CartController::class, 'remove'])->name('cart.remove');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    
    Route::get('/account', [UserController::class, 'index'])->name('account.index');
    Route::post('/account/update', [UserController::class, 'update'])->name('account.update');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Admin Products
    Route::resource('admin/products', AdminProductController::class, ['as' => 'admin']);
    
    // Admin Categories
    Route::resource('admin/categories', AdminCategoryController::class, ['as' => 'admin']);
    
    // Admin Orders
    Route::resource('admin/orders', AdminOrderController::class, ['as' => 'admin'])->only(['index', 'show', 'update']);
    
    // Admin Customers
    Route::get('admin/customers', [AdminCustomerController::class, 'index'])->name('admin.customers.index');
    
    // Admin Settings (Admin Management)
    // Using a custom resource-like structure or just resource. Resource works if we map parameter 'admin' to 'user' or just use 'settings'
    // But since model is User, let's explicit define to avoid confusion or use resource with parameter mapping
    Route::resource('admin/settings', AdminSettingsController::class, ['as' => 'admin'])->parameters(['settings' => 'admin']);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

Route::get('/debug-user', function () {
    if (!auth()->check()) {
        return "Not logged in";
    }
    return [
        'name' => auth()->user()->name,
        'email' => auth()->user()->email,
        'role' => auth()->user()->role,
    ];
});

// TEMPORARY: Run this once on the live site to set up the DB
Route::get('/deploy-setup', function () {
    try {
        $url = config('database.connections.mysql.url');
        if (!$url) { return "ERROR: DATABASE_URL is missing in Railway Variables."; }
        
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return "NOW CONNECTED TO MYSQL: Database tables created successfully! <br><br> Log: " . \Illuminate\Support\Facades\Artisan::output();
    } catch (\Exception $e) {
        return "CRITICAL ERROR: " . $e->getMessage();
    }
});
