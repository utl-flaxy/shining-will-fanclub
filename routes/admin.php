<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\FanController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TalkController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\TalentController;
use App\Http\Controllers\Admin\WatchdogController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Admin Login
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware('guest')
    ->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.process');
    });

/*
|--------------------------------------------------------------------------
| Admin Area（auth + role:admin）
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

        Route::get('/home', fn () => view('admin.home'))->name('home');

        Route::resource('posts', PostController::class)->except(['show']);
        Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

        Route::prefix('talks')->name('talks.')->group(function () {
            Route::get('/', [TalkController::class, 'index'])->name('index');
            Route::get('/{talk}', [TalkController::class, 'show'])->name('show');
        });

        Route::resource('items', ItemController::class)->except(['show']);
        Route::resource('talents', TalentController::class)->except(['show']);

        Route::prefix('watchdog')->name('watchdog.')->group(function () {
            Route::get('/', [WatchdogController::class, 'index'])->name('index');
            Route::get('/{id}', [WatchdogController::class, 'show'])->name('show');
            Route::delete('/{id}', [WatchdogController::class, 'delete'])->name('delete');
            Route::post('/ban/{userId}', [WatchdogController::class, 'ban'])->name('ban');
        });

        Route::get('/fans', [FanController::class, 'index'])->name('fans.index');
        Route::get('/fans/{fan}', [FanController::class, 'show'])->name('fans.show');
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    });
