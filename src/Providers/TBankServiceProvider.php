<?php

namespace DFiks\TBank\Providers;

use Illuminate\Support\ServiceProvider;

class TBankServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../configs/tbank.php' => config_path('tbank.php'),
        ], 'config');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../configs/tbank.php',
            'tbank'
        );
    }
}
