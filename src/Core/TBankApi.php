<?php

namespace DFiks\TBank\Core;

use DFiks\TBank\Configuration\Contracts\ConfigurationInterface;
use DFiks\TBank\Configuration\General\GeneralConfiguration;
use DFiks\TBank\Configuration\Shop\ShopConfiguration;
use DFiks\TBank\Payments\Methods\Standard\StandardPayments;
use DFiks\TBank\Payments\Request\ApiRequest;
use Illuminate\Support\Facades\Config;

class TBankApi
{
    protected static bool $debug = false;
    protected static ?string $shopNameStatic = null;
    protected static ?ShopConfiguration $shopConfiguration = null;
    protected static ?GeneralConfiguration $generalConfiguration = null;

    public function __construct(?string $shopName = null)
    {
        self::$debug = static::isDebug();
        self::$shopNameStatic = $shopName;

        [self::$shopConfiguration, self::$generalConfiguration] = app(ConfigurationInterface::class);
    }

    /**
     * Инициализация API с именем магазина.
     *
     * @param  string   $shopName
     * @return TBankApi
     */
    public static function init(string $shopName): self
    {
        return new self($shopName);
    }

    public function standard(): StandardPayments
    {
        return new StandardPayments(
            new ApiRequest(self::getShopConfiguration(), self::getGeneralConfiguration())
        );
    }

    /**
     * Проверка, находится ли система в режиме отладки (debug).
     *
     * @return bool
     */
    public static function isDebug(): bool
    {
        return Config::get('tbank.debug', true);
    }

    /**
     * Получить текущую конфигурацию магазина.
     *
     * @return ShopConfiguration
     */
    public static function getShopConfiguration(): ShopConfiguration
    {
        return self::$shopConfiguration ?? app(ShopConfiguration::class);
    }

    /**
     * Получить текущую общую конфигурацию.
     *
     * @return GeneralConfiguration
     */
    public static function getGeneralConfiguration(): GeneralConfiguration
    {
        return self::$generalConfiguration ?? app(GeneralConfiguration::class);
    }
}
