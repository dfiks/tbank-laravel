<?php

namespace DFiks\TBank\Configuration\Shop\Exceptions;

use Exception;

class ShopConfigurationNotFoundException extends Exception
{
    private ?string $shopName;
    private bool $noConfigurations;

    public function __construct(?string $shopName = null, bool $noConfigurations = false)
    {
        $this->shopName = $shopName;
        $this->noConfigurations = $noConfigurations;

        $red = "\033[31m";
        $yellow = "\033[33m";
        $reset = "\033[0m";

        if ($this->noConfigurations) {
            $message = $red . "\n\nНи одного магазина не найдена в$reset tbank.php$red конфигурации." . $reset . PHP_EOL;
            $message .= $yellow . 'Убедитесь, что файл tbank.php содержит хотя бы одну конфигурацию.' . $reset . PHP_EOL;
        } else {
            $message = $red . "\n\nКонфигурация магазина '$yellow{$this->shopName}$red' не найдена в$reset tbank.php$red." . $reset . PHP_EOL;
            $message .= $yellow . 'Убедитесь, что конфигурация для магазина указана правильно.' . $reset . PHP_EOL;
        }

        parent::__construct($message);
    }

    /**
     * Исключение, когда конкретная конфигурация магазина не найдена.
     *
     * @param  string $shopName
     * @return static
     */
    public static function fromMissingShopConfiguration(string $shopName): self
    {
        return new static($shopName);
    }

    /**
     * Исключение, когда ни одной конфигурации магазинов нет.
     *
     * @return static
     */
    public static function fromNoConfigurations(): self
    {
        return new static(null, true);
    }
}
