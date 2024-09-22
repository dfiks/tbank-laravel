<?php

namespace DFiks\TBank\Providers;

use Carbon\Laravel\ServiceProvider;
use DFiks\TBank\Configuration\Contracts\ConfigurationInterface;
use DFiks\TBank\Configuration\General\GeneralConfiguration;
use DFiks\TBank\Configuration\Shop\Exceptions\ShopConfigurationNotFoundException;
use DFiks\TBank\Configuration\Shop\ShopConfiguration;

class TBankConfigurationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ShopConfiguration::class, function ($app) {
            $shops = config('tbank.shops');

            if (empty($shops)) {
                throw ShopConfigurationNotFoundException::fromNoConfigurations();
            }

            $shopName = config('tbank.default_shop');
            if (empty($shopName) || !isset($shops[$shopName])) {
                if (empty($shopName)) {
                    $shopName = array_key_first($shops);
                } else {
                    throw ShopConfigurationNotFoundException::fromMissingShopConfiguration($shopName);
                }
            }

            return new ShopConfiguration($shopName);
        });

        $this->app->singleton(GeneralConfiguration::class, function ($app) {
            return new GeneralConfiguration();
        });

        $this->app->singleton(ConfigurationInterface::class, function ($app) {
            return [
                $app->make(ShopConfiguration::class),
                $app->make(GeneralConfiguration::class),
            ];
        });
    }

    public function boot(): void
    {
    }
}
