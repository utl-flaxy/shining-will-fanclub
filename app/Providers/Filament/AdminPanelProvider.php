<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Pages\Dashboard;
use Spatie\Permission\Middlewares\RoleMiddleware;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')

            /**
             * ✅ 重要
             * Filamentのログイン画面は使わない
             * （自作 /admin/login を使う）
             */
            ->login(false)

            ->profile()

            ->pages([
                Dashboard::class,
            ])

            ->colors([
                'primary' => Color::Blue,
            ])

            /**
             * ✅ Webセッション + Filament必須Middleware
             */
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,

                /**
                 * ✅ official ロール限定
                 */
                RoleMiddleware::class . ':official',
            ])

            /**
             * ✅ Laravel認証は使う（ログイン済み前提）
             */
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
