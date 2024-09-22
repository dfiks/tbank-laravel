<?php

namespace DFiks\TBank\Providers;

use DFiks\TBank\Webhook\Controller\WebhookController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TBankRouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
    }

    public function register(): void
    {
        if (!$this->app->runningInConsole()) {
            $methods = explode(',', Config::get('tbank.generals.webhook.route_webhook_allowed_methods'));

            Route::match($methods, Config::get('tbank.generals.webhook.route_webhook'), [
                WebhookController::class,
                'webhook',
            ]);
        }
    }
}
