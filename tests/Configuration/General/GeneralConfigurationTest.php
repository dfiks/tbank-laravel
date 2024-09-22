<?php

namespace DFiks\TBank\Tests\Configuration\General;

use DFiks\TBank\Configuration\General\Exceptions\GeneralConfigurationException;
use DFiks\TBank\Configuration\General\GeneralConfiguration;
use DFiks\TBank\Tests\Configuration\ConfigurationCase;

class GeneralConfigurationTest extends ConfigurationCase
{
    /**
     * Возвращаем ключ конфигурации для `GeneralConfiguration`.
     *
     * @return string
     */
    protected function configKey(): string
    {
        return 'tbank.generals';
    }

    /**
     * Получаем объект конфигурации для `GeneralConfiguration`.
     *
     * @return GeneralConfiguration
     */
    protected function getConfiguration(): GeneralConfiguration
    {
        return new GeneralConfiguration();
    }

    /**
     * Возвращаем валидную конфигурацию для теста.
     *
     * @return array
     */
    protected function validConfig(): array
    {
        return [
            'api_version' => 'v2',
            'endpoints' => [
                'test' => 'https://rest-api-test.tinkoff.ru',
                'production' => 'https://securepay.tinkoff.ru',
            ],
        ];
    }

    /**
     * Возвращаем невалидную конфигурацию для теста.
     *
     * @return array
     */
    protected function invalidConfig(): array
    {
        return [
            'endpoints' => [
                'test' => 'invalid-url',
            ],
        ];
    }

    protected function exceptionClass(): string
    {
        return GeneralConfigurationException::class;
    }
}
