<?php

namespace DFiks\TBank\Configuration\Shop\Exceptions;

use DFiks\TBank\Configuration\BaseConfigurationException;

class ShopConfigurationException extends BaseConfigurationException
{
    protected function getErrorHeader(): string
    {
        return "\nКонфигурация магазина содержит ошибки:";
    }
}
