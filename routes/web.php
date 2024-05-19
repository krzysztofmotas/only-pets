<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Models\PostAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::controller(HomeController::class)->group(function() {
    Route::get('/', function(Request $request) {
        if ($request->ajax()) {
            // Log::info('home request by ajax');

            $controller = new HomeController();
            return $controller->index($request);
        } else {
            // Log::info('home request by user');

            return view(Auth::check() ? 'home.index' : 'guest.index');
        }
    });
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/auth/login', 'login')->name('login');
    Route::post('/auth/login', 'handle')->name('login.handle');
    Route::post('/auth/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/auth/register', 'register')->name('register');
    Route::post('/auth/register', 'handle')->name('register.handle');
});

Route::controller(PostController::class)->group(function () {
    Route::post('/post/store', 'store')->name('post.store');
});

// Route::controller(PostAttachment::class)->group(function () {
//     Route::post('/auth/register', 'store')->name('post.store.attachment');
// });
