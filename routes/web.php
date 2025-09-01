<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;

Route::get('/clear', function() {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    return redirect()->back();
});
 Route::middleware('auth')->group(function () {
Route::controller(CheckoutController::class)->group(function () {

    Route::get('/checkOutPage', 'checkOutPage')->name('checkOutPage');
Route::post('/checkout/update-shipping', 'updateShipping')->name('checkout.shipping.update');
    Route::post('/checkout/apply-coupon', 'applyCoupon')->name('checkout.coupon.apply');
    Route::post('/checkout/remove-coupon', 'removeCoupon')->name('checkout.coupon.remove');
    Route::post('/checkout/place-order', 'placeOrder')->name('checkout.place.order');
    Route::get('/order-success', 'orderSuccess')->name('order.success');
});



});
// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register.show');
    Route::post('/register', 'register')->name('register.submit');
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');

    Route::get('/otp-verification', 'showOtpForm')->name('otp.verification');
    Route::post('/otp-verification', 'verifyOtp')->name('otp.verify');
    Route::post('/resend-otp', 'resendOtp')->name('otp.resend');

    // Password Reset
    Route::get('/forgot-password', 'showForgotPasswordForm')->name('password.request');
    Route::post('/forgot-password', 'sendPasswordResetLink')->name('password.email');
    Route::get('/reset-password/{token}', 'showResetPasswordForm')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')->name('password.update');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard-user', 'dashboarduser')->name('dashboard.user');
        Route::post('/track-order', 'trackOrder')->name('track.order'); 
          Route::post('/dashboard-profile-update', 'updateProfile')->name('dashboard.profile.update');
        Route::post('/dashboard-password-update', 'updatePassword')->name('dashboard.password.update');
    });
});

Route::controller(FrontController::class)->group(function () {

Route::post('/track-order', 'trackOrder')->name('tracking.track');
    Route::get('/about-us', 'aboutUs')->name('about-us');
    Route::get('/support', 'support')->name('support');
    Route::get('/orderTracking', 'orderTracking')->name('orderTracking');

    Route::get('/product-search', 'searchProducts')->name('product.search');

    Route::get('/', 'index')->name('home.index');
    Route::get('/category/{slug}', 'category')->name('category.show');
    Route::get('/subcategory/{slug}', 'subcategory')->name('subcategory.show');
    // ADD THESE NEW ROUTES FOR THE OFFER PAGE
    Route::get('/offer/{slug}','offer')->name('offer.show');
    Route::get('/offers/filter','filterOffers')->name('offer.filter');

    Route::get('/animation-category/{slug}', 'animationCategory')->name('animation.category.show');
    Route::get('/animation-category-filter', 'filterAnimationCategory')->name('animation.category.filter');

    Route::get('/shop', 'shop')->name('shop.show');
    Route::get('/product/{slug}', 'product')->name('product.show');
    Route::get('/shop-filter', 'ajaxShopFilter')->name('shop.ajax_filter');
    Route::get('products-filter', 'filterProducts')->name('products.filter');
     Route::get('/product-quick-view/{id}', 'quickView')->name('product.quick_view');

});

// START: MODIFIED CART ROUTES

Route::controller(CartController::class)->prefix('cart')->name('cart.')->group(function () {
     Route::get('/', 'show')->name('show');
    Route::post('/add', 'addToCart')->name('add');
    Route::get('/content', 'getCartContent')->name('content');
    Route::post('/update', 'updateCartItem')->name('update');
    Route::post('/remove', 'removeCartItem')->name('remove');
    Route::post('/clear', 'clearCart')->name('clear'); // Add this route
});
// END: MODIFIED CART ROUTES
