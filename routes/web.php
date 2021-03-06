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
Route::get('/view/product/{slug}',[App\Http\Controllers\ProductsController::class, 'viewProduct'])->name('viewProduct');

Route::view('demo','demo');
Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group( function (){
    
    //cart
    Route::post('/cart', [App\Http\Controllers\CartController::class, 'store'])->name('cart');
    Route::get('/checkout', [App\Http\Controllers\CartController::class, 'index'])->name('checkout');
    Route::post('/checkout/get/items', [App\Http\Controllers\CartController::class, 'getCartItemsForCheckout'])->name('checkout.items');

    //products
    
    Route::post('/process/user/payment', [App\Http\Controllers\ProcessingController::class, 'processPayment'])->name('process.payment');
    Route::post('/product/update/quantity', [App\Http\Controllers\CartController::class, 'updateProductQty'])->name('update.product.quantity');
    Route::post('/product/remove', [App\Http\Controllers\CartController::class, 'removeProduct'])->name('product.remove');


});

