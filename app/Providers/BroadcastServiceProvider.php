<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;


class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // ONLY register the API broadcasting auth under /api
        Broadcast::routes([
            'prefix'     => 'api',
            'middleware' => ['auth:sanctum'],
        ]);

        // load your channel definitions
        require base_path('routes/channels.php');
    }
}
