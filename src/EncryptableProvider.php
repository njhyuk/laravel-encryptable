<?php

namespace Njhyuk\LaravelEncryptable;

use Illuminate\Support\ServiceProvider;

class EncryptableProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/encryptable.php' => config_path('encryptable.php')
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/encryptable.php', 'encryptable');
    }
}
