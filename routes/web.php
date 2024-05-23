<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', function (Request $request) {
        if ($request->ajax()) {
            // Log::info('home request by ajax');

            $controller = new HomeController();
            return $controller->index($request);
        } else {
            // Log::info('home request by user');

            if (Auth::check()) {
                $controller = new HomeController();
                return $controller->index($request);
            }

            return view('guest.index');
        }
    })->name('home');

    Route::get('/search', 'search')->name('search')->middleware('auth');
});

Route::controller(UserController::class)->middleware('auth')->group(function () {
    Route::view('/settings', 'settings.index')->name('settings');
    Route::put('/settings/password', 'updatePassword')->name('settings.password');
    Route::put('/settings/name', 'updateName')->name('settings.name');
    Route::put('/settings/display-name', 'updateDisplayName')->name('settings.display.name');
    Route::put('/settings/other', 'updateOtherInfo')->name('settings.other.info');
    Route::put('/settings/avatar', 'updateAvatar')->name('settings.avatar');
    Route::delete('/settings/avatar/delete', 'deleteAvatar')->name('settings.delete.avatar');
    Route::put('/settings/background', 'updateBackground')->name('settings.background');
    Route::delete('/settings/background/delete', 'deleteBackground')->name('settings.delete.background');
    Route::get('/profile/{user:name}', 'profile')->name('profile');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/auth/login', 'login')->name('login');
    Route::post('/auth/login', 'handle')->name('login.handle');
    Route::post('/auth/logout', 'logout')->name('logout')->middleware('auth');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/auth/register', 'register')->name('register');
    Route::post('/auth/register', 'handle')->name('register.handle');
});

Route::controller(PostController::class)->group(function () {
    Route::post('/post/store', 'store')->name('post.store');
    Route::delete('/post/destroy/{post}', 'destroy')->name('post.destroy');
});

// https://stackoverflow.com/questions/73261188/laravel-auth-component-not-available-on-error-views
Route::fallback(function () {
    return abort(404);
});
