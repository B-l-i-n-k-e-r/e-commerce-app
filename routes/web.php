<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductAdminController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MailtrapController;
use App\Http\Controllers\PHPMailerController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Manager\ManagerDashboardController;
use App\Http\Controllers\CategoryController;
use App\Models\Product;


// ========================= M-PESA ROUTES =========================
Route::get('/mpesa/test-token', [MpesaController::class, 'getAccessToken']);
Route::post('/mpesa/stk-push', [MpesaController::class, 'stkPush'])->name('stkpush');
Route::post('/mpesa/callback', [MpesaController::class, 'handleCallback'])->name('mpesa.callback');

// ========================= PUBLIC PRODUCT ROUTES =========================
// Homepage
Route::get('/', function () {
    // Fetch all products with their categories to make the filter work
    $products = Product::with('category')->get();
    
    return view('welcome', compact('products'));
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// ========================= CART ROUTES =========================
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [ProductController::class, 'viewCart'])->name('view');
    
    // Standard Redirect route
    Route::post('/add/{id}', [ProductController::class, 'addToCart'])->name('add');
    
    // NEW: AJAX route for Quick Add
    Route::post('/add-ajax/{id}', [ProductController::class, 'addToCartAjax'])->name('add.ajax');
    // Inside the 'cart' prefix group in web.php
Route::post('/add-ajax/{id}', [ProductController::class, 'addToCartAjax'])->name('add.ajax');
    Route::post('/update/{id}', [ProductController::class, 'updateCart'])->name('update');
    Route::post('/update-quantity/{id}', [ProductController::class, 'updateQuantityAjax'])->name('update-quantity');
    Route::delete('/remove/{id}', [ProductController::class, 'removeFromCart'])->name('remove');
    Route::get('/count', [ProductController::class, 'getCartCount'])->name('count');
});

// ========================= PASSWORD RESET ROUTES =========================
// Place these BEFORE Auth::routes() to ensure they take precedence
// Allow GET request for reset form (accessible even when logged in)
Route::get('reset-password/{token}', function ($token) {
    // Simple closure to bypass all middleware issues
    return view('auth.reset-password', [
        'token' => $token,
        'email' => request('email')
    ]);
})->name('password.reset');

// Forgot password routes (these should remain guest-only)
Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
});

// POST route for resetting password - accessible to both guests AND authenticated users
Route::post('reset-password', [NewPasswordController::class, 'store'])
    ->name('password.store');

// ========================= AUTH ROUTES =========================
// Disable default reset routes since we're using custom ones
Auth::routes(['verify' => true, 'reset' => false]);

// ========================= AUTHENTICATED USER ROUTES =========================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/notifications', [ProfileController::class, 'updateNotifications'])->name('profile.update.notifications');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update.photo');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.view');
    Route::post('/checkout/createOrder', [CheckoutController::class, 'createOrder'])->name('checkout.createOrder');
    Route::post('/checkout/process', function () {
        return view('orders.confirmation');
    })->name('checkout.process.order');
    Route::get('/checkout/confirmation/{order_id?}', [CheckoutController::class, 'showConfirmation'])->name('checkout.confirmation');
    Route::get('/order/status/{order_id}', [CheckoutController::class, 'checkStatus'])->name('order.status');
    Route::delete('/order/cancel/{order_id}', [CheckoutController::class, 'cancelOrder'])->name('order.cancel');
    Route::post('/checkout/process-order', [CheckoutController::class, 'processOrder'])->name('checkout.processOrder');

    // Payment
    Route::get('/payment/{order_id}', [PaymentController::class, 'showPaymentPage'])->name('payment.method');
    Route::post('/payment/{order_id}', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/order-confirmation/{order_id}', [PaymentController::class, 'confirmOrder'])->name('order.confirmation');

    // Order Viewing (For Customers)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/confirmation', [CheckoutController::class, 'showConfirmation'])->name('orders.confirmation');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
});

// ========================= ADMIN & MANAGER ROUTES =========================
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        
        // Product Management
        Route::resource('products', ProductAdminController::class);
        Route::get('product-listing', [ProductAdminController::class, 'index'])->name('admin.product.listing');

        // Order Management
        Route::resource('orders', OrderAdminController::class);
        Route::patch('/orders/{order}/archive', [OrderAdminController::class, 'archive'])->name('orders.archive');

        // User Management
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/verify', [UserController::class, 'verifyEmail'])->name('users.verify');
        Route::post('/users/{user}/makeAdmin', [UserController::class, 'promoteToAdmin'])->name('users.makeAdmin');
        Route::post('/users/{user}/toggleManager', [UserController::class, 'toggleManager'])->name('users.toggleManager');

        // Reports & Misc
        Route::get('reports', [ReportController::class, 'index'])->name('reports');
        Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
        Route::get('/password-requests', [AdminController::class, 'showPasswordRequests'])->name('password.requests');
        Route::post('/password-requests/{user}/approve', [AdminController::class, 'approvePasswordRequest'])->name('password.requests.approve');
        Route::post('/password-requests/{user}/reject', [AdminController::class, 'rejectPasswordRequest'])->name('password.requests.reject');
        Route::get('inventory/low-stock', [ProductAdminController::class, 'lowStock'])->name('inventory.low-stock');
        
        // Category
        Route::resource('categories', CategoryController::class);   
});

// ========================= MANAGER SPECIFIC =========================
Route::middleware(['auth', 'manager'])->group(function () {
    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
});

// ========================= EXTERNAL & UTILITY =========================
Route::post('/confirm-transaction', [TransactionController::class, 'confirmTransaction'])->name('confirm.transaction');
Route::get('/test-phpmailer', [PHPMailerController::class, 'testMail']);

// ========================= FALLBACK (ALWAYS LAST) =========================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});