<?php

namespace Den1n\ConcurrentSessions;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Event;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../migrations' => database_path('migrations'),
        ], 'migrations');

        Event::listen(Authenticated::class, Listeners\Authenticated::class);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
    }
}
