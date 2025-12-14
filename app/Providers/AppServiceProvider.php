<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ページネーションを Tailwind に統一
        Paginator::useTailwind();

        // カート数量を全ページで共有
        View::composer('members.layouts.app', function ($view) {
            $cart = session('cart', []);
            $count = 0;

            foreach ($cart as $item) {
                $count += $item['quantity'] ?? 0;
            }

            $view->with('cartCount', $count);
        });
    }
}
