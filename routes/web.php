<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ✅ Admin Routes（最優先）
|--------------------------------------------------------------------------
*/
require __DIR__ . '/admin.php';

/*
|--------------------------------------------------------------------------
| ✅ Breeze Auth (User)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| ✅ Member Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/members.php';

/*
|--------------------------------------------------------------------------
| ✅ Talent Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/talent.php';

/*
|--------------------------------------------------------------------------
| ✅ Like / Comment
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\PostCommentController;

Route::middleware(['auth'])->group(function () {
    Route::post('/posts/{post}/like', [PostLikeController::class, 'toggle'])
        ->name('posts.like');

    Route::post('/posts/{post}/comment', [PostCommentController::class, 'store'])
        ->name('posts.comment.store');

    Route::delete('/comments/{comment}', [PostCommentController::class, 'destroy'])
        ->name('posts.comment.destroy');
});

/*
|--------------------------------------------------------------------------
| ✅ Watchdog
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:watchdog'])
    ->prefix('watchdog')
    ->name('watchdog.')
    ->group(function () {
        Route::get('/home', fn () => 'WATCHDOG HOME')->name('home');
    });

/*
|--------------------------------------------------------------------------
| ✅ Root Redirect（ログイン後の初期遷移）
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])
    ->get('/', fn () => redirect()->route('members.home'));

/*
|--------------------------------------------------------------------------
| ✅ Fallback
|--------------------------------------------------------------------------
*/
Route::fallback(fn () => abort(404));
