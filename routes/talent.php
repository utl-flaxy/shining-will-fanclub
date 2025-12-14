<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Talent\AuthController;
use App\Http\Controllers\Talent\PostController;
use App\Http\Controllers\TalentTalkController;
use App\Http\Controllers\Talent\HomeController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| タレント ログイン（未ログイン時）
|--------------------------------------------------------------------------
*/
Route::prefix('talent')->name('talent.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

/*
|--------------------------------------------------------------------------
| タレント専用エリア（ログイン後）
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:talent'])
    ->prefix('talent')
    ->name('talent.')
    ->group(function () {

        // ===== ホーム =====
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        // ===== 🔔 通知一覧 =====
        Route::get('/notifications', function (Request $request) {

            $notifications = $request->user()
                ->notifications()
                ->latest()
                ->get();

            return view('talent.notifications.index', compact('notifications'));

        })->name('notifications.index');

        // ===== 投稿 =====
        Route::prefix('posts')->name('posts.')->group(function () {

            Route::get('/', [PostController::class, 'index'])->name('index');
            Route::get('/create', [PostController::class, 'create'])->name('create');
            Route::post('/', [PostController::class, 'store'])->name('store');

            Route::get('/{post}', [PostController::class, 'show'])->name('show');
            Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
            Route::post('/{post}/update', [PostController::class, 'update'])->name('update');
            Route::delete('/{post}/delete', [PostController::class, 'destroy'])->name('delete');
        });

        // ===== コメント削除 =====
        Route::delete('/comments/{comment}', [PostController::class, 'deleteComment'])
            ->name('comments.delete');

        // ===== トーク =====
        Route::prefix('talks')->name('talks.')->group(function () {
            Route::get('/', [TalentTalkController::class, 'index'])->name('index');
            Route::get('/{room}', [TalentTalkController::class, 'show'])->name('show');
            Route::post('/{room}/send', [TalentTalkController::class, 'send'])->name('send');
        });
    });
