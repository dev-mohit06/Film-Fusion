<?php

use App\Http\Controllers\AccountContorller;
use App\Http\Controllers\AdminControllers\DashboardController;
use App\Http\Controllers\AdminControllers\MoviesController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('UserAuth')->group(function () {


    //with login routes
    Route::prefix('/user')->group(function () {
        Route::get('/home', [MoviesController::class, 'returnMoviesAccordingUi'])->name('user.home');

        Route::get('/watch-later', function () {
            return view('with-login.watch-later');
        })->name('user.watch-later');

        Route::get('/favorite', function () {
            return view('with-login.favorite');
        })->name('user.favorite');

        Route::get('/history', function () {
            return view('with-login.history');
        })->name('user.history');

        Route::get('/settings', [UserController::class, 'returnSettings'])->name('user.settings');
        Route::get('/deleteUser', [UserController::class, 'deleteCurrentUser'])->name('user.settings.delete');

        Route::get('/play-page/{movie_id?}', [MoviesController::class, 'returnSpecificMovie'])->name('user.play-page');

        Route::get('/edit-profile', [UserController::class, 'returnEditProfile'])->name('user.edit-profile');
        Route::post('/updateUser', [UserController::class, 'updateProfile'])->name('user.edit-profile.updateUser');
    });


    //Admin routes
    Route::prefix('/admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


        //user page
        Route::get('/users', function () {
            return view('admin.users');
        })->name('admin.users');
        Route::get('/getAllUsers', [UserController::class, 'getUsersTable'])->name('admin.users.getAll');
        Route::get('/getUserInsertForm', [UserController::class, 'getInsertForm'])->name('admin.users.getInsertForm');
        Route::get('/getUserUpdateForm', [UserController::class, 'getUpdateForm'])->name('admin.users.getUpdateForm');
        Route::post('/insertWithSubscription', [UserController::class, 'insertWithSubscription'])->name('admin.users.insertWithSubscription');
        Route::post('/updateWithSubscription', [UserController::class, 'updateWithSubscription'])->name('admin.users.updateWithSubscription');
        Route::get('/deleteUser', [UserController::class, 'deleteUser'])->name('admin.users.delete');


        Route::get('/movies', function () {
            return view('admin.movies');
        })->name('admin.movies');
        Route::get('/getAllMovies', [MoviesController::class, 'getMoviesTable'])->name('admin.movies.getAll');
        Route::post('/insertMovie', [MoviesController::class, 'insert'])->name('admin.movies.insertMovie');
        Route::get('/getMovieUpdateForm', [MoviesController::class, 'getUpdateForm'])->name('admin.movies.getUpdateForm');
        Route::post('/updateMovie', [MoviesController::class, 'update'])->name('admin.movies.updateMovie');
        Route::get('/deleteMovie', [MoviesController::class, 'delete'])->name('admin.movies.deleteMovie');


        Route::get('/offers', function () {
            return view('admin.offers');
        })->name('admin.offers');
        Route::get('/getAllOffers', [DiscountController::class, 'getOffersTable'])->name('admin.offers.getAll');
        Route::post('/insertOffer', [DiscountController::class, 'createNewOffer'])->name('admin.offers.insert');
        Route::get('/getOfferUpdateForm', [DiscountController::class, 'getUpdateForm'])->name('admin.offers.getUpdateForm');
        Route::post('/updateOffers', [DiscountController::class, 'update'])->name('admin.offers.update');
        Route::get('/deleteOffers', [DiscountController::class, 'delete'])->name('admin.offers.delete');

        Route::get('/plans', function () {
            return view('admin.plans');
        })->name('admin.plans');
        Route::get('/getAllPlans', [PlanController::class, 'getPlansTable'])->name('admin.plans.getAll');
        Route::post('/insertPlan', [PlanController::class, 'insert'])->name('admin.plans.insert');
        Route::get('/getPlanUpdateForm', [PlanController::class, 'getUpdateForm'])->name('admin.plans.getUpdateForm');
        Route::post('/updatePlan', [PlanController::class, 'update'])->name('admin.plans.update');
        Route::get('/deletePlan', [PlanController::class, 'delete'])->name('admin.plans.delete');

        Route::get('/analytics', function () {
            return view('admin.analytics');
        })->name('admin.analytics');

        Route::get('/subscription-histroy', function () {
            return view('admin.subscription-histroy');
        })->name('admin.subscription-histroy');
        Route::get('/getAllSubscription', [SubscriptionController::class, 'getSubscriptionTable'])->name('admin.subscription-histroy.getAll');

        Route::get('/refrel-histroy', function () {
            return view('admin.refrel-histroy');
        })->name('admin.refrel-histroy');
    });



    //Without login routes
    Route::get('/home', function () {
        return view('index');
    })->name('home');
    Route::redirect('/', '/home');

    Route::get('/pricing', [PlanController::class, 'getPricingCardView'])->name('pricing');

    Route::get('/discount/{planId}', [PlanController::class, 'returnDiscountView'])->name('discount');

    Route::get('/login/{refCode?}', function (string $refrelCode = null) {
        if ($refrelCode == null) {
            return view('login');
        } else {
            return view('login');
        }
    })->name('login');

    Route::get('/forget-password', function () {
        return view('forgot_password');
    })->name('forget_password');
    Route::post('/sendForgetLink', [AccountContorller::class, 'sendResetLink'])->name('forget_password.sendLink');
    Route::get('/verifyResetLink/{token}', [AccountContorller::class, 'verifyResetLink'])->name('forget_password.verifylink');
    Route::get('/change-password', function () {
        if (!session()->has('forgot_password_user_id')) {
            return redirect()->route('login');
        }
        return view('reset_password');
    })->name('forget_password.update_password');
    Route::post('/change-password', [AccountContorller::class, 'changePassword'])->name('forget_password.update');


    // Action Performing routes
    // Routes for creating ,login and logout
    Route::post('/user-create', [UserController::class, 'insert'])->name("user.create");
    Route::post('/login', [AccountContorller::class, 'login'])->name('postLogin');
    Route::get('/logout', [AccountContorller::class, 'logout'])->name('logout');

    // Routes for account activation
    Route::get('/activate/{token}', [AccountContorller::class, 'accountActivator'])->name('activate');

    // Route for apply discout
    Route::get('/applyCoupn', [DiscountController::class, 'applyOffer'])->name('applyCoupn');

    // Routes for payment gateway.
    Route::get('/checkout', [SubscriptionController::class, 'checkout'])->name('checkout');
    Route::get('/afterCheckout', [SubscriptionController::class, 'afterCheckout'])->name('afterCheckout');
});
