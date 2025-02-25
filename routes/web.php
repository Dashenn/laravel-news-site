<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NewsController::class, 'index'])->name('home');

Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

Route::middleware('guest')->group(function () {
    Route::get('register', [App\Http\Controllers\UserController::class, 'create'])->name('register');
    Route::post('register', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');

    Route::get('login', [App\Http\Controllers\UserController::class, 'login'])->name('login');
    Route::post('login', [App\Http\Controllers\UserController::class, 'loginAuth'])->name('login.auth');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');
    Route::get('account', [App\Http\Controllers\UserController::class, 'account'])->name('account');
    Route::get('article/create', [App\Http\Controllers\NewsController::class, 'create'])->name('article.create');
    Route::get('/user/news', [App\Http\Controllers\UserController::class, 'news'])->name('user.news');
    Route::get('/user/liked-news', [App\Http\Controllers\UserController::class, 'likedNews'])->name('user.likedNews');

});

Route::post('/news/{id}/like', [NewsController::class, 'like'])->name('news.like');
