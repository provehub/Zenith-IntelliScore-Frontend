<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Social\PublishManager;
use App\Social\XPublisher;
use App\Social\FacebookPagePublisher;
use App\Social\InstagramPublisher;
use App\Social\TikTokPublisher;

class SocialServiceProvider extends ServiceProvider
{
    // NOTE: drop ": void" if your server runs an older PHP
    public function register()
    {
        $this->app->singleton(PublishManager::class, function ($app) {
            return new PublishManager([
                'x'         => $app->make(XPublisher::class),
                'facebook'  => $app->make(FacebookPagePublisher::class),
                'instagram' => $app->make(InstagramPublisher::class),
                'tiktok'    => $app->make(TikTokPublisher::class),
            ]);
        });
    }

    public function boot()
    {
        // optional
    }
}
