<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Cart API Routes
Route::prefix('cart')->name('api.cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('add', [CartController::class, 'addItem'])->name('add');
    Route::put('update/{itemId}', [CartController::class, 'updateItem'])->name('update');
    Route::delete('remove/{itemId}', [CartController::class, 'removeItem'])->name('remove');
    Route::delete('clear', [CartController::class, 'clear'])->name('clear');
    Route::get('count', [CartController::class, 'count'])->name('count');
    
    Route::post('coupon', [CartController::class, 'applyCoupon'])->name('applyCoupon');
    Route::delete('coupon', [CartController::class, 'removeCoupon'])->name('removeCoupon');
});

// User authentication routes
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
