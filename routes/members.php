<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Members\HomeController;
use App\Http\Controllers\Members\TalkController;
use App\Http\Controllers\FanclubPostController;
use App\Http\Controllers\Members\ItemsController;
use App\Http\Controllers\Members\CartController;
use App\Http\Controllers\Members\CheckoutController;
use App\Http\Controllers\Members\SettingsController;

Route::middleware(['web', 'auth', 'role:user'])
    ->prefix('members')
    ->name('members.')
    ->group(function () {

        /* ================== ホーム ================== */
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        /* ================== トーク ================== */
        Route::prefix('talks')->name('talks.')->group(function () {
            Route::get('/', [TalkController::class, 'index'])->name('index');
            Route::get('/{talk}', [TalkController::class, 'show'])->name('show');
            Route::post('/{talk}/send', [TalkController::class, 'send'])->name('send');
        });

        /* ================== 投稿 ================== */
        Route::prefix('posts')->name('posts.')->group(function () {
            Route::get('/', [FanclubPostController::class, 'index'])->name('index');
            Route::get('/{post}', [FanclubPostController::class, 'show'])->name('show');
        });

        /* ================== ショップ ================== */
        Route::prefix('items')->name('items.')->group(function () {

            // ショップ一覧
            Route::get('/', [ItemsController::class, 'index'])->name('index');

            // ✅ マイアイテム一覧（先に書く）
            Route::get('/owned', [ItemsController::class, 'owned'])->name('owned');

            // 商品詳細
            Route::get('/{item}', [ItemsController::class, 'show'])->name('show');
        });

        /* ================== カート ================== */
        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/add/{item}', [CartController::class, 'add'])->name('add');
            Route::post('/remove/{item}', [CartController::class, 'remove'])->name('remove');
            Route::post('/increase/{item}', [CartController::class, 'increase'])->name('increase');
            Route::post('/decrease/{item}', [CartController::class, 'decrease'])->name('decrease');
        });

        /* ================== 購入フロー ================== */
        Route::prefix('checkout')->name('checkout.')->group(function () {
            Route::post('/confirm', [CheckoutController::class, 'confirm'])->name('confirm');
            Route::post('/complete', [CheckoutController::class, 'complete'])->name('complete');
        });

        /* ================== 設定 ================== */
        Route::prefix('settings')->name('settings.')->group(function () {

            // 設定トップ
            Route::get('/', [SettingsController::class, 'index'])->name('index');

            // アカウント情報
            Route::get('/account', [SettingsController::class, 'account'])->name('account');
            Route::post('/account/update', [SettingsController::class, 'updateAccount'])->name('account.update');

            // パスワード変更
            Route::get('/password', [SettingsController::class, 'password'])->name('password');
            Route::post('/password/update', [SettingsController::class, 'updatePassword'])->name('password.update');

            // 購入履歴
            Route::get('/purchases', [SettingsController::class, 'purchaseHistory'])->name('purchases');

            // 着せ替えテーマ
            Route::get('/themes', [SettingsController::class, 'themes'])->name('themes');
            Route::post('/themes/apply', [SettingsController::class, 'applyTheme'])->name('themes.apply');

            // デジタル会員証
            Route::get('/membership', [SettingsController::class, 'membership'])->name('membership');
        });
    });
