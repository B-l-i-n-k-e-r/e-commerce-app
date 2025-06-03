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
use App\Services\MailtrapService;


// ========================= M-PESA ROUTES =========================
Route::get('/mpesa/test-token', [MpesaController::class, 'getAccessToken']);
Route::post('/mpesa/stk-push', [MpesaController::class, 'stkPush'])->name('stkpush');
Route::post('/mpesa/callback', [MpesaController::class, 'handleCallback'])->name('mpesa.callback');

// ========================= PUBLIC PRODUCT ROUTES =========================
Route::get('/', function () {
    return view('welcome');
});
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// ========================= CART ROUTES =========================
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [ProductController::class, 'viewCart'])->name('view');
    Route::post('/add/{id}', [ProductController::class, 'addToCart'])->name('add');
    Route::post('/update/{id}', [ProductController::class, 'updateCart'])->name('update');
    Route::post('/update-quantity/{id}', [ProductController::class, 'updateQuantityAjax'])->name('update-quantity');
    Route::delete('/remove/{id}', [ProductController::class, 'removeFromCart'])->name('remove');
});

// ========================= AUTH ROUTES =========================
Auth::routes(['verify' => true]);

// ========================= PASSWORD RESET ROUTES (GUEST-ONLY) =========================
Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    Route::get('reset-password/{token}', [\App\Http\Controllers\Auth\NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [\App\Http\Controllers\Auth\NewPasswordController::class, 'store'])
        ->name('password.update');
});

// ========================= AUTHENTICATED USER ROUTES =========================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ===== Profile Routes =====
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/notifications', [ProfileController::class, 'updateNotifications'])->name('profile.update.notifications');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update.photo');

    // ===== Checkout Routes =====
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.view');
    Route::post('/checkout/createOrder', [CheckoutController::class, 'createOrder'])->name('checkout.createOrder');
    Route::post('/checkout/process', function () {
        return view('orders.confirmation');
    })->name('checkout.process.order');
    Route::get('/checkout/confirmation', [CheckoutController::class, 'showConfirmation'])->name('checkout.confirmation');

    // ===== Payment Routes =====
    Route::get('/payment/{order_id}', [PaymentController::class, 'showPaymentPage'])->name('payment.method');
    Route::post('/payment/{order_id}', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/order-confirmation/{order_id}', [PaymentController::class, 'confirmOrder'])->name('order.confirmation');

    // ===== Email Verification =====
    Route::post('/email/verification-notification', [VerificationController::class, 'resend'])->name('verification.send');

    // ===== Order Viewing =====
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/confirmation', [CheckoutController::class, 'showConfirmation'])->name('orders.confirmation');

    // ===== Notifications =====
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
});

// ========================= ADMIN ROUTES =========================
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update.photo');
        
        // ===== Product Management =====
        Route::resource('products', ProductAdminController::class);
        Route::get('product-listing', [ProductAdminController::class, 'index'])->name('admin.product.listing');

        // ===== Order Management =====
        Route::resource('orders', OrderAdminController::class);
        Route::patch('/orders/{order}/archive', [OrderAdminController::class, 'archive'])->name('orders.archive');

        // ===== Report Management =====
        Route::get('reports', [ReportController::class, 'index'])->name('reports');
        Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');

        // ===== User Management =====
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/verify', [UserController::class, 'verifyEmail'])->name('users.verify');
        Route::post('/users/{user}/makeAdmin', [UserController::class, 'promoteToAdmin'])->name('users.makeAdmin');

        // ===== Password Reset Requests Management =====
        Route::get('/password-requests', [AdminController::class, 'showPasswordRequests'])->name('password.requests');
        Route::post('/password-requests/{user}/approve', [AdminController::class, 'approvePasswordRequest'])->name('password.requests.approve');
        Route::post('/password-requests/{user}/reject', [AdminController::class, 'rejectPasswordRequest'])->name('password.requests.reject');
    });

// ========================= FALLBACK ROUTE (404) =========================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

// ========================= TRANSACTION CONFIRMATION =========================
Route::post('/confirm-transaction', [TransactionController::class, 'confirmTransaction'])->name('confirm.transaction');


// Route that returns Mailtrap inbox messages as JSON (API-style)
Route::get('/api/mailtrap/inbox', function (MailtrapService $mailtrapService) {
    $messages = $mailtrapService->fetchInboxMessages();
    return response()->json($messages);
})->name('mailtrap.api.inbox');

// Route that returns a Blade view showing the inbox messages nicely formatted
Route::get('/mailtrap/inbox', [MailtrapController::class, 'inbox'])->name('mailtrap.inbox');

Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/admin/password/reset/{user}', [AdminController::class, 'approvePasswordReset'])
         ->name('admin.password.reset.approve');
});