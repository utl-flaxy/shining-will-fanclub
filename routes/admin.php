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
use App\Http\Controllers\Admin\StampController;
use App\Http\Controllers\Admin\QrScanController;

/*
|--------------------------------------------------------------------------
| Admin Login（未ログイン）
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware('guest')
    ->group(function () {

        Route::get('/login', [AdminLoginController::class, 'showLogin'])
            ->name('login');

        Route::post('/login', [AdminLoginController::class, 'login'])
            ->name('login.process');
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

        Route::post('/logout', [AdminLoginController::class, 'logout'])
            ->name('logout');

        Route::get('/home', function () {
            return view('admin.home');
        })->name('home');

        Route::resource('posts', PostController::class)
            ->except(['show']);

        Route::get('/posts/{post}', [PostController::class, 'show'])
            ->name('posts.show');

        Route::prefix('talks')
            ->name('talks.')
            ->group(function () {
                Route::get('/', [TalkController::class, 'index'])->name('index');
                Route::get('/{talk}', [TalkController::class, 'show'])->name('show');
            });

        Route::resource('items', ItemController::class)
            ->except(['show']);

        Route::prefix('items/{item}/stamps')
            ->name('stamps.')
            ->group(function () {
                Route::get('/', [StampController::class, 'index'])->name('index');
                Route::post('/', [StampController::class, 'store'])->name('store');
                Route::post('/reorder', [StampController::class, 'reorder'])->name('reorder');
                Route::delete('/{stamp}', [StampController::class, 'destroy'])->name('destroy');
            });

        Route::resource('talents', TalentController::class)
            ->except(['show']);

        Route::prefix('watchdog')
            ->name('watchdog.')
            ->group(function () {
                Route::get('/', [WatchdogController::class, 'index'])->name('index');
                Route::get('/{id}', [WatchdogController::class, 'show'])->name('show');
                Route::delete('/{id}', [WatchdogController::class, 'delete'])->name('delete');
                Route::post('/ban/{userId}', [WatchdogController::class, 'ban'])->name('ban');
            });

        Route::get('/fans', [FanController::class, 'index'])
            ->name('fans.index');

        Route::get('/fans/{fan}', [FanController::class, 'show'])
            ->name('fans.show');

        Route::get('/settings', [SettingController::class, 'index'])
            ->name('settings.index');

        /*
        |--------------------------------------------------------------------------
        | ✅ QRスキャン（追加）
        |--------------------------------------------------------------------------
        */
        Route::get('/qr/scan', [QrScanController::class, 'scan'])
            ->name('qr.scan');
    });
