<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [App\Http\Controllers\ProductsController::class, 'index'])->name('main');
Route::get('/products', [App\Http\Controllers\ProductsController::class, 'getProducts'])->name('getProducts');

Route::view('demo','demo');
Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group( function (){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/cart', [App\Http\Controllers\CartController::class, 'store'])->name('cart');
    Route::get('/checkout', [App\Http\Controllers\CartController::class, 'index'])->name('checkout');

    Route::post('/checkout/get/items', [App\Http\Controllers\CartController::class, 'getCartItemsForCheckout'])->name('checkout.items');

    Route::post('/process/user/payment', [App\Http\Controllers\CartController::class, 'processPayment'])->name('process.payment');


});

