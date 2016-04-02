<?php

namespace kubacode\telstraSMS;

use Illuminate\Support\ServiceProvider;

class SMSServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/sms.php', 'sms'
        );

        $this->app->bind('SMS', function ($app) {
            return new telstraSMS(config('sms.apiKey'), config('sms.apiSecret'));
        });
    }

    public function provides()
    {
        return ['SMS'];
    }
}
