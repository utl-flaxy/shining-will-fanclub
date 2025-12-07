<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\CreateDmForNewUser;
use App\Models\User;
use App\Observers\UserObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Breeze標準のメール認証
        Registered::class => [
            SendEmailVerificationNotification::class,
            // 新規ユーザー登録時に DM を自動生成
            CreateDmForNewUser::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // User 作成/更新などを監視したい場合（既に作ってあるならそのまま）
        User::observe(UserObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
