<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * 全リクエスト共通ミドルウェア
     */
    protected $middleware = [
        \Illuminate\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * ミドルウェアグループ
     */
    protected $middlewareGroups = [

        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // CSRF エラーやバリデーションエラーの表示に必要
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * ルートミドルウェア
     *
     * Laravel 11 では alias は public
     */
    public $middlewareAliases = [

        /*
        |--------------------------------------------------------------------------
        | Laravel 標準
        |--------------------------------------------------------------------------
        */
        'auth'              => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic'        => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers'     => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can'               => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'             => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm'  => \Illuminate\Auth\Middleware\RequirePassword::class,
        'precognitive'      => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        'signed'            => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle'          => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified'          => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        /*
        |--------------------------------------------------------------------------
        | アプリ独自
        |--------------------------------------------------------------------------
        */
        'active'            => \App\Http\Middleware\ActiveMember::class,
        'subscribed'        => \App\Http\Middleware\Subscribed::class,
        'redirect.after.login' => \App\Http\Middleware\RedirectAfterLogin::class,

        /*
        |--------------------------------------------------------------------------
        | Spatie Permission
        |--------------------------------------------------------------------------
        */
        'role'              => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        'permission'        => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        'role_or_permission'=> \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
    ];
}
