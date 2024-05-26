<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;

Route::controller(HomeController::class)
    ->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/search', 'search')->name('search');
        Route::get('/profile/{user:name}', 'profile')->name('profile');

        Route::get('/notifications', 'getNotifications')->middleware('auth')->name('notifications');
        Route::get('/notifications/clear', 'clearNotifications')->middleware('auth')->name('notifications.clear');
    });

Route::controller(SubscriptionController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/subscriptions/buy/{user:name}', 'buyView')->name('subscriptions.buy');
        Route::post('/subscriptions/buy/{user:name}', 'store')->name('subscriptions.store');
        Route::get('/subscriptions/buy/success', 'successView')->name('subscriptions.success');
        Route::get('/subscriptions', 'index')->name('subscriptions.index');
    });

Route::controller(UserController::class)
    ->middleware('auth')
    ->group(function () {
        Route::view('/settings', 'settings.index')->name('settings');
        Route::put('/settings/password', 'updatePassword')->name('settings.password');
        Route::put('/settings/name', 'updateName')->name('settings.name');
        Route::put('/settings/display-name', 'updateDisplayName')->name('settings.display.name');
        Route::put('/settings/other', 'updateOtherInfo')->name('settings.other.info');
        Route::put('/settings/avatar', 'updateAvatar')->name('settings.avatar');
        Route::delete('/settings/avatar/delete', 'deleteAvatar')->name('settings.delete.avatar');
        Route::put('/settings/background', 'updateBackground')->name('settings.background');
        Route::delete('/settings/background/delete', 'deleteBackground')->name('settings.delete.background');
    });

Route::controller(LoginController::class)
    ->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('login', 'handle')->name('login.handle');
        Route::post('logout', 'logout')->name('logout')->middleware('auth');
    });

Route::controller(RegisterController::class)
    ->group(function () {
        Route::get('register', 'register')->name('register');
        Route::post('register', 'handle')->name('register.handle');
    });

Route::controller(PostController::class)
    ->group(function () {
        Route::post('/post/store', 'store')->name('post.store');
        Route::delete('/post/destroy/{post}', 'destroy')->name('post.destroy');
    });

// https://stackoverflow.com/questions/73261188/laravel-auth-component-not-available-on-error-views
Route::fallback(function () {
    return abort(404);
});
