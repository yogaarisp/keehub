<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Builder\BuilderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RakitanController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// SEO sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Shop
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/produk/{slug}', [ShopController::class, 'show'])->name('shop.show');

// PC Rakitan
Route::get('/pc-rakitan', [RakitanController::class, 'index'])->name('rakitan.index');

// Service
Route::get('/service', [ServiceRequestController::class, 'create'])->name('service.create');
Route::post('/service', [ServiceRequestController::class, 'store'])->name('service.store')->middleware('throttle:10,1');

// PC Builder (share view public)
Route::get('/pc-builder', [BuilderController::class, 'index'])->name('builder.index');
Route::get('/pc-builder/build/{token}', [BuilderController::class, 'show'])->name('builder.show');

// Builder API
Route::prefix('builder/api')->group(function () {
    Route::get('/components/{slot}', [BuilderController::class, 'components'])->name('builder.components');
    Route::get('/check', [BuilderController::class, 'check'])->name('builder.check');
    Route::post('/save', [BuilderController::class, 'save'])->name('builder.save')->middleware(['auth', 'throttle:30,1']);
    Route::post('/add-to-cart', [BuilderController::class, 'addToCart'])->name('builder.add-to-cart')->middleware(['auth', 'throttle:30,1']);
});

// Cart & checkout
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add')->middleware('throttle:30,1');
Route::post('/cart/buy-now/{product}', [CartController::class, 'buyNow'])->name('cart.buy-now')->middleware('throttle:30,1');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update')->middleware('throttle:60,1');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove')->middleware('throttle:60,1');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('throttle:10,1');

// Customer account
Route::middleware(['auth'])->prefix('account')->group(function () {
    Route::get('/', [AccountController::class, 'dashboard'])->name('account.dashboard');
    Route::get('/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/orders/{order}', [AccountController::class, 'showOrder'])->name('account.orders.show');
    Route::get('/builds', [AccountController::class, 'builds'])->name('account.builds');
});

// Breeze dashboard → arahkan sesuai role
Route::get('/dashboard', function () {
    return auth()->user()->isAdmin() ? redirect(url('/admin')) : redirect()->route('account.dashboard');
})->middleware(['auth'])->name('dashboard');

// Profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
