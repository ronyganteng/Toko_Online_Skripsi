<?php

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerPasswordController;
use App\Http\Controllers\CustomerProfileController;

// ================== HALAMAN UMUM ==================
Route::get('/', [TransaksiController::class, 'index'])->name('home');
Route::post('/addToCart', [TransaksiController::class, 'addToCart'])->name('addToCart');
Route::get('/shop', [\App\Http\Controllers\Controller::class, 'shop'])->name('shop');
Route::get('/contact', [\App\Http\Controllers\Controller::class, 'contact'])->name('contact');

// ================== AUTH CUSTOMER ==================
Route::get('/customer/login', [CustomerAuthController::class, 'showLogin'])->name('customer.login');
Route::post('/customer/login', [CustomerAuthController::class, 'login'])->name('customer.login.post');

Route::get('/customer/register', [CustomerAuthController::class, 'showRegister'])->name('customer.register');
Route::post('/customer/register', [CustomerAuthController::class, 'register'])->name('customer.register.post');

Route::post('/customer/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

// ============= CUSTOMER FORGOT PASSWORD ============
Route::get('/customer/password/forgot', [CustomerPasswordController::class, 'showLinkRequestForm'])
    ->name('customer.password.request');

Route::post('/customer/password/email', [CustomerPasswordController::class, 'sendResetLinkEmail'])
    ->name('customer.password.email');

Route::get('/customer/password/reset/{token}', [CustomerPasswordController::class, 'showResetForm'])
    ->name('customer.password.reset');

Route::post('/customer/password/reset', [CustomerPasswordController::class, 'reset'])
    ->name('customer.password.update');

// ============= ROUTE YANG HARUS LOGIN CUSTOMER =====
Route::middleware('auth:customer')->group(function () {

    // PROFIL PELANGGAN
    Route::get('/profile', [CustomerProfileController::class, 'show'])
        ->name('customer.profile');              // ⬅️ tadinya index, sekarang show

    Route::get('/profile/edit', [CustomerProfileController::class, 'edit'])
        ->name('customer.profile.edit');

    Route::post('/profile', [CustomerProfileController::class, 'update'])
        ->name('customer.profile.update');

    Route::post('/profile/password', [CustomerProfileController::class, 'updatePassword'])
        ->name('customer.profile.password');

    // TRANSAKSI & CHECKOUT
    Route::get('/transaksi', [\App\Http\Controllers\Controller::class, 'transaksi'])->name('transaksi');
    Route::get('/checkout', [\App\Http\Controllers\Controller::class, 'checkout'])->name('checkout');
    Route::post('/checkout/proses/{id}', [\App\Http\Controllers\Controller::class, 'prosesCheckout'])->name('checkout.product');
    Route::post('/checkout/prosesPembayaran', [\App\Http\Controllers\Controller::class, 'prosesPembayaran'])->name('checkout.bayar');
});


// ================== ADMIN AREA ==================
Route::post('/admin/loginProses', [AdminController::class, 'loginProses'])->name('loginProses');
Route::get('/admin', [AdminController::class, 'login'])->name('login');
Route::get('/admin/dashboard', [AdminController::class, 'admin'])->name('admin');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('logout');
Route::get('/admin/product', [ProductController::class, 'index'])->name('product');

Route::get('/admin/user_management', [UserController::class, 'index'])->name('userManagement');
Route::get('/admin/editUser/{id}', [UserController::class, 'show'])->name('showDataUser');
Route::put('/admin/updateDataUser/{id}', [UserController::class, 'update'])->name('updateDataUser');
Route::delete('/admin/deleteUser/{id}', [UserController::class, 'destroy'])->name('destroyDataUser');
Route::post('/admin/addUser', [UserController::class, 'store'])->name('addDataUser');

Route::get('/admin/report', [KeuanganController::class, 'index'])->name('report');
Route::post('/admin/report/store', [KeuanganController::class, 'store'])->name('report.store');
Route::put('/admin/report/{id}', [KeuanganController::class, 'update'])->name('report.update');
Route::delete('/admin/report/{id}', [KeuanganController::class, 'destroy'])->name('report.destroy');
Route::get('/admin/addModal', [ProductController::class, 'addModal'])->name('addModal');
Route::get('/admin/addModalUser', [UserController::class, 'addModalUser'])->name('addModalUser');
Route::delete('/admin/product/{id}', [ProductController::class,'destroy'])->name('product.destroy');

Route::post('/admin/addData', [ProductController::class, 'store'])->name('addData');
Route::get('/admin/editModal/{id}', [ProductController::class, 'show'])->name('editModal');
Route::put('/admin/updateData/{id}', [ProductController::class, 'update'])->name('updateData');

// TEST ALERT
Route::get('/coba-alert', function () {
    Alert::success('Berhasil', 'SweetAlert Berfungsi!');
    return view('pelanggan.page.contact', ['title' => 'Contact Us', 'count' => 0]);
});
