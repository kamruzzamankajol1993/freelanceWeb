<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CartController;

Route::get('/clear', function() {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    return redirect()->back();
});

Route::controller(FrontController::class)->group(function () {

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
