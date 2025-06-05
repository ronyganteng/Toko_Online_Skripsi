<?php

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[\App\Http\Controllers\TransaksiController::class, 'index'])->name('home');
Route::POST('/addToCart',[\App\Http\Controllers\TransaksiController::class, 'addToCart'])->name('addToCart');
Route::get('/shop',[\App\Http\Controllers\Controller::class, 'shop'])->name('shop');
Route::get('/transaksi',[\App\Http\Controllers\Controller::class, 'transaksi'])->name('transaksi');
Route::get('/contact',[\App\Http\Controllers\Controller::class, 'contact'])->name('contact');

Route::get('/checkout',[\App\Http\Controllers\Controller::class, 'checkout'])->name('checkout');
Route::POST('/checkout/proses/{id}',[\App\Http\Controllers\Controller::class, 'prosesCheckout'])->name('checkout.product');
Route::POST('/checkout/prosesPembayaran',[\App\Http\Controllers\Controller::class, 'prosesPembayaran'])->name('checkout.bayar');

Route::post('/admin/loginProses', [AdminController::class, 'loginProses'])->name('loginProses');
Route::get('/admin', [AdminController::class, 'login'])->name('login');
Route::get('/admin/dashboard', [AdminController::class, 'admin'])->name('admin');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('logout');
Route::get('/admin/product', [ProductController::class, 'index'])->name('product');

Route::get('/admin/user_management', [UserController::class, 'index'])->name('userManagement');
Route::get('/admin/editUser/{id}', [UserController::class, 'show'])->name('showDataUser');
Route::PUT('/admin/updateDataUser/{id}', [UserController::class, 'update'])->name('updateDataUser');
Route::DELETE('/admin/deleteUser/{id}', [UserController::class, 'destroy'])->name('destroyDataUser');
Route::POST('/admin/addUser', [UserController::class, 'store'])->name('addDataUser');

Route::get('/admin/report', [AdminController::class, 'report'])->name('report');
Route::get('/admin/addModal', [ProductController::class, 'addModal'])->name('addModal');
Route::GET('/admin/addModalUser', [UserController::class, 'addModalUser'])->name('addModalUser');
Route::get('/admin/delete', [ProductController::class,'delete'])->name('delete');


Route::POST('/admin/addData', [ProductController::class, 'store'])->name('addData');
Route::GET('/admin/editModal/{id}', [ProductController::class, 'show'])->name('editModal');
Route::PUT('/admin/updateData/{id}', [ProductController::class, 'update'])->name('updateData');

Route::get('/coba-alert', function () {
    \RealRashid\SweetAlert\Facades\Alert::success('Berhasil', 'SweetAlert Berfungsi!');
    return view('pelanggan.page.contact', ['title' => 'Contact Us', 'count' => 0]);
});