<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\userAuthController;
use App\Http\Controllers\userPaymentController;
use App\Http\Controllers\VendorAuthController;
use App\Http\Controllers\Vendors\VendorDashboard;
use App\Http\Controllers\WebsiteController;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebsiteController::class,'index']);

Route::get('/home', [WebsiteController::class,'index']);

Route::middleware('guest')->group(function(){

    //Inscription
Route::get('/register', [userAuthController::class,'register'])->name('user.register');
Route::post('/register',[userAuthController::class,'handleRegister'])->name('handleUserRegister');

//Connexion
Route::get('/login', [userAuthController::class,'login'])->name('user.login');

Route::post('/login',[userAuthController::class,'handleLogin'])->name('handleUserLogin');

});

//Route pour les utilisateurs connectés

Route::middleware('auth')->group(function(){


    Route::get('/articles/order/{id}', [userPaymentController::class, 'initPayment'])->name('order.article');

//Deconnexion
Route::get('/logout', [userAuthController::class,'handleLogout'])->name('user.logout');
});


//Route pour les vendeurs 

//Vendeur GUEST [AUTH]

Route::prefix('vendors/accounts')->group(function(){
Route::get('/login', [VendorAuthController::class,'login'])->name('vendors.login');
Route::get('/register',  [VendorAuthController::class,'register'])->name('vendors.register');

Route::post('/login', [VendorAuthController::class, 'handleLogin'] )->name('vendors.handleLogin');
Route::post('/register', [VendorAuthController::class, 'handleRegister'] )->name('vendors.handleRegister');

});

    Route:: middleware ('vendor')->prefix('vendors/dashboard')->
    group( function (){
        Route::get('/',[VendorDashboard::class,'index'])->name('vendors.dashboard');
       


        Route::prefix('articles')->group(function(){

            Route::get('/', [ArticleController::class,'index'])
            ->name('articles.index');

            Route::get('/create',[ArticleController::class,'create'])
            ->name('articles.create');

            Route::post('/create',[ArticleController::class,'handleCreate'])
            ->name('articles.handleCreate');
        });

        Route::get('payment-configuration',[PaymentController::class,'getAccountInfo'])->name('payments.configuration');

        Route::post('handle-payment-configuration',[PaymentController::class,'handleUpdateInfo'])->name('payments.updateconfiguration');

        Route::get('/logout',[VendorDashboard::class,'logout'])->name('vendors.logout');
 
    });


