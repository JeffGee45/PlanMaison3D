<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserPaymentController;
use App\Http\Controllers\VendorAuthController;
use App\Http\Controllers\Vendors\VendorDashboard;
use App\Http\Controllers\Web\CartController as WebCartController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\HousePlanController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\CustomizationRequestController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

// Routes du site web
Route::get('/', [WebsiteController::class, 'index'])->name('home');
Route::get('/a-propos', [WebsiteController::class, 'about'])->name('about');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');
Route::post('/contact', [WebsiteController::class, 'handleContact'])->name('contact.submit');

// Routes pour les plans de maison
Route::get('/nos-plans', [HousePlanController::class, 'index'])->name('house-plans.index');
Route::get('/nos-plans/{plan}', [HousePlanController::class, 'show'])->name('house-plans.show');
Route::get('/nos-plans/{plan}/download', [HousePlanController::class, 'downloadPDF'])->name('house-plans.download');

// Routes pour les demandes de personnalisation
Route::get('/customization-requests/create/{plan}', [CustomizationRequestController::class, 'create'])->name('customization-requests.create');
Route::post('/customization-requests', [CustomizationRequestController::class, 'store'])->name('customization-requests.store');

// Routes du panier (Web)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [WebCartController::class, 'index'])->name('index');
    Route::post('add', [WebCartController::class, 'addItem'])->name('add');
    Route::post('{item}/remove', [WebCartController::class, 'removeItem'])->name('remove');
    Route::post('clear', [WebCartController::class, 'clear'])->name('clear');
});

// Routes du blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

// Routes d'administration
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Tableau de bord
    Route::get('/', function () {
        return view('admin.index');
    })->name('dashboard');

    // Gestion des coupons
    Route::resource('coupons', AdminCouponController::class)->except(['show']);
    Route::get('coupons/{coupon}', [AdminCouponController::class, 'show'])->name('coupons.show');
    Route::post('coupons/{coupon}/toggle-status', [AdminCouponController::class, 'toggleStatus'])
        ->name('coupons.toggle-status');

    // Gestion des articles du blog
    Route::resource('posts', AdminPostController::class);
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
    // Paiement
    Route::get('/checkout', [UserPaymentController::class, 'showCheckout'])->name('checkout');
    Route::post('/process-payment', [UserPaymentController::class, 'processPayment'])->name('process.payment');
    Route::get('/payment/success', [UserPaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/cancel', [UserPaymentController::class, 'paymentCancel'])->name('payment.cancel');
    
    Route::get('/articles/order/{id}', [UserPaymentController::class, 'initPayment'])->name('order.article');
    
    //Deconnexion
    Route::get('/logout', [UserAuthController::class, 'handleLogout'])->name('user.logout');

    // Profil utilisateur
    Route::get('/profil', [UserAuthController::class, 'profile'])->name('user.profile');
    Route::post('/profil', [UserAuthController::class, 'updateProfile'])->name('user.updateProfile');
    
    // Commandes utilisateur
    Route::get('/mes-commandes', [UserAuthController::class, 'orders'])->name('user.orders');
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

    // Gestion des articles
    Route::prefix('articles')->group(function () {
        Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
        Route::get('/create', [ArticleController::class, 'create'])->name('articles.create');
        Route::post('/create', [ArticleController::class, 'handleCreate'])->name('articles.handleCreate');
    });

    // Configuration des paiements
    Route::get('payment-configuration', [PaymentController::class, 'getAccountInfo'])->name('payments.configuration');
    Route::post('handle-payment-configuration', [PaymentController::class, 'handleUpdateInfo'])->name('payments.updateconfiguration');

    // Déconnexion
    Route::get('/logout', [VendorDashboard::class, 'logout'])->name('vendors.logout');
});
