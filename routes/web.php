<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserPaymentController;
use App\Http\Controllers\VendorAuthController;
use App\Http\Controllers\Vendors\VendorDashboard;
use App\Http\Controllers\Web\CartController as WebCartController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\HousePlanController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

// Routes du site web
Route::get('/', [WebsiteController::class, 'index'])->name('home');
Route::get('/home', [WebsiteController::class, 'index']);
Route::get('/a-propos', [WebsiteController::class, 'about'])->name('about');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');
Route::post('/contact', [WebsiteController::class, 'handleContact'])->name('contact.submit');

// Routes pour les plans de maison
Route::get('/nos-plans', [HousePlanController::class, 'index'])->name('house-plans.index');
Route::get('/nos-plans/{plan:slug}', [HousePlanController::class, 'show'])->name('house-plans.show');

// Routes du panier (Web)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [WebCartController::class, 'index'])->name('index');
    Route::post('add', [WebCartController::class, 'addItem'])->name('add');
    Route::post('clear', [WebCartController::class, 'clear'])->name('clear');
});

// Routes d'administration des coupons
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('coupons', AdminCouponController::class)->except(['show']);
    Route::get('coupons/{coupon}', [AdminCouponController::class, 'show'])->name('coupons.show');
    Route::post('coupons/{coupon}/toggle-status', [AdminCouponController::class, 'toggleStatus'])
        ->name('coupons.toggle-status');
});

Route::middleware('guest')->group(function () {

    //Inscription
    Route::get('/register', [UserAuthController::class, 'register'])->name('user.register');
    Route::post('/register', [UserAuthController::class, 'handleRegister'])->name('handleUserRegister');

    //Connexion
    Route::get('/login', [UserAuthController::class, 'login'])->name('user.login');
    Route::post('/login', [UserAuthController::class, 'handleLogin'])->name('handleUserLogin');
});

//Route pour les utilisateurs connectés
Route::middleware('auth')->group(function () {


    Route::get('/articles/order/{id}', [UserPaymentController::class, 'initPayment'])->name('order.article');

    //Deconnexion
    Route::get('/logout', [UserAuthController::class, 'handleLogout'])->name('user.logout');
});


//Route pour les vendeurs

//Vendeur GUEST [AUTH]

Route::prefix('vendors/accounts')->group(function () {
    Route::get('/login', [VendorAuthController::class, 'login'])->name('vendors.login');
    Route::get('/register',  [VendorAuthController::class, 'register'])->name('vendors.register');

    Route::post('/login', [VendorAuthController::class, 'handleLogin'])->name('vendors.handleLogin');
    Route::post('/register', [VendorAuthController::class, 'handleRegister'])->name('vendors.handleRegister');
});

Route::middleware('vendor')->prefix('vendors/dashboard')->group(function () {
        Route::get('/', [VendorDashboard::class, 'index'])->name('vendors.dashboard');



        Route::prefix('articles')->group(function () {

            Route::get('/', [ArticleController::class, 'index'])
                ->name('articles.index');

            Route::get('/create', [ArticleController::class, 'create'])
                ->name('articles.create');

            Route::post('/create', [ArticleController::class, 'handleCreate'])
                ->name('articles.handleCreate');
        });

        Route::get('payment-configuration', [PaymentController::class, 'getAccountInfo'])->name('payments.configuration');

        Route::post('handle-payment-configuration', [PaymentController::class, 'handleUpdateInfo'])->name('payments.updateconfiguration');

        Route::get('/logout', [VendorDashboard::class, 'logout'])->name('vendors.logout');
    });
