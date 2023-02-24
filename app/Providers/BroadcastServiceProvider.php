<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $authMiddleware = config('jetstream.guard')
            ? 'auth:' . config('jetstream.guard')
            : 'auth';

        $authSessionMiddleware = config('jetstream.auth_session', false)
            ? config('jetstream.auth_session')
            : null;

        $attributes = [array_values(array_filter([$authMiddleware, $authSessionMiddleware]))];

        Broadcast::routes([
            'middleware' => 'auth:api',
            'prefix' => 'api'
        ]);

        require base_path('routes/channels.php');
    }
}
