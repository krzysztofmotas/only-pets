<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdminController;

Route::controller(HomeController::class)
    ->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/search/{nav?}', 'search')->name('search');
        Route::get('/profile/{user:name}', 'profile')->name('profile');
        Route::get('/ranks', 'ranks')->name('ranks');

        Route::get('/notifications', 'getNotifications')->middleware('auth')->name('notifications');
        Route::get('/notifications/clear', 'clearNotifications')->middleware('auth')->name('notifications.clear');
    });


Route::post('/subscriptions/switch-auto-renew', [SubscriptionController::class, 'switchAutoRenew'])->name('subscriptions.switch.auto.renew');

Route::controller(SubscriptionController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/subscriptions/buy/{user:name}', 'buyView')->name('subscriptions.buy');
        Route::post('/subscriptions/buy/{user:name}', 'store')->name('subscriptions.store');
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

Route::controller(AdminController::class)
    ->middleware('can:admin')
    ->group(function () {
        Route::get('/users', 'users')->name('admin.users.index');
        Route::get('/users/{user:name}', 'user')->name('admin.users.edit');
        Route::delete('/users/delete/{user:name}', 'delete')->name('admin.users.delete');
        Route::put('/users/update/{user:name}', 'update')->name('admin.users.update');
        Route::put('/users/update-avatar/{user:name}', 'updateAvatar')->name('admin.users.update.avatar');
        Route::put('/users/update-background/{user:name}', 'updateBackground')->name('admin.users.update.background');
        Route::delete('/users/delete-avatar/{user:name}', 'deleteAvatar')->name('admin.users.delete.avatar');
        Route::delete('/users/delete-background/{user:name}', 'deleteBackground')->name('admin.users.delete.background');
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
        Route::get('/post/edit/{post:id}', 'edit')->name('post.edit');
        Route::put('/post/update/{post}', 'update')->name('post.update');
        Route::delete('/post/attachment/delete/{attachment}', 'deleteAttachment')->name('post.attachment.delete');
    });

// https://stackoverflow.com/questions/73261188/laravel-auth-component-not-available-on-error-views
Route::fallback(function () {
    return abort(404);
});
