<?php

namespace NotificationChannels\Apn;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Pushok\AuthProvider\Token;
use Pushok\Client;

class ApnServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Token::class, function ($app) {
            $options = Arr::except($app['config']['broadcasting.connections.apn'], 'production');

            return Token::create($options);
        });

        $this->app->bind(Client::class, function ($app) {
            return new Client($app->make(Token::class), $app['config']['broadcasting.connections.apn.production'], [CURLOPT_CAINFO=>base_path('scripts/cacert.pem')]);
        });
    }
}
