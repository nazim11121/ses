<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CompanyProfileController as AdminCompanyProfileController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/shop', [ProductController::class, 'index'])->name('products.index');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('product.category');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('product.category');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('sliders', AdminSliderController::class)->except(['show']);
    Route::resource('contacts', AdminContactController::class)->only(['index', 'destroy']);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::get('pages/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
    Route::put('pages/update', [AdminPageController::class, 'update'])->name('pages.update');
    Route::get('profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/password', [AdminProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::resource('company-profiles', AdminCompanyProfileController::class)->except(['show']);
});
