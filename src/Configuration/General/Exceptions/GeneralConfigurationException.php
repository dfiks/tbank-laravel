<?php

namespace DFiks\TBank\Configuration\General\Exceptions;

use DFiks\TBank\Configuration\BaseConfigurationException;

class GeneralConfigurationException extends BaseConfigurationException
{
    protected function getErrorHeader(): string
    {
        return "\nКонфигурация общих настроек содержит ошибки:";
    }
}
