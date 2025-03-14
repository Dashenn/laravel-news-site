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
    Route::get('/user/liked-news', [App\Http\Controllers\UserController::class, 'likedNews'])->name('user.liked-news');
    Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');
    Route::post('/update-avatar', [App\Http\Controllers\UserController::class, 'updateAvatar'])->name('update.avatar');
    Route::delete('/news/{id}', [App\Http\Controllers\UserController::class, 'deleteNews'])->name('news.delete');
    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');
});

Route::post('/news/{id}/like', [NewsController::class, 'like'])->name('news.like');

use App\Http\Controllers\AdminController;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    Route::delete('/news/{id}', [AdminController::class, 'deleteNews'])->name('admin.deleteNews');
});

Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');
