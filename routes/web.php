<?php

use App\Http\Controllers\AccountContorller;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::middleware('UserAuth')->group(function () {


    //with login routes
    Route::prefix('/user')->group(function () {
        Route::get('/home', function () {
            return view('with-login.index');
        })->name('user.home');

        Route::get('/watch-later', function () {
            return view('with-login.watch-later');
        })->name('user.watch-later');

        Route::get('/favorite', function () {
            return view('with-login.favorite');
        })->name('user.favorite');

        Route::get('/history', function () {
            return view('with-login.history');
        })->name('user.history');

        Route::get('/settings', function () {
            return view('with-login.settings');
        })->name('user.settings');

        Route::get('/play-page', function () {
            return view('with-login.play-page');
        })->name('user.play-page');

        Route::get('/edit-profile', function () {
            return view('with-login.edit-profile');
        })->name('user.edit-profile');
    });


    //Admin routes
    Route::prefix('/admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        Route::redirect('/', '/dashboard');

        Route::get('/users', function () {
            return view('admin.users');
        })->name('admin.users');

        Route::get('/movies', function () {
            return view('admin.movies');
        })->name('admin.movies');

        Route::get('/offers', function () {
            return view('admin.offers');
        })->name('admin.offers');

        Route::get('/analytics', function () {
            return view('admin.analytics');
        })->name('admin.analytics');

        Route::get('/subscription-histroy', function () {
            return view('admin.subscription-histroy');
        })->name('admin.subscription-histroy');

        Route::get('/refrel-histroy', function () {
            return view('admin.refrel-histroy');
        })->name('admin.refrel-histroy');
    });


    //Without login routes
    Route::get('/home', function () {
        return view('index');
    })->name('home');
    Route::redirect('/', '/home');

    Route::get('/pricing', function () {
        return view('pricing');
    })->name('pricing');

    Route::get('/discount/{planId}',[PlanController::class,'getPlan'])->name('discount');

    Route::get('/login', function () {
        return view('login');
    })->name('login');


    // Action Performing routes
    // Routes for creating ,login and logout
    Route::post('/user-create', [UserController::class, 'insert'])->name("user.create");
    Route::post('/login', [AccountContorller::class, 'login'])->name('postLogin');
    Route::get('/logout',[AccountContorller::class,'logout'])->name('logout');

    // Routes for account activation deactivation
    Route::get('/activate/{token}', [AccountContorller::class, 'accountActivator'])->name('activate');

    // Route for apply discout
    Route::get('/applyCoupn',[DiscountController::class,'applyOffer'])->name('applyCoupn');
    Route::get('/pay',[SubscriptionController::class,'pay'])->name('pay');
});