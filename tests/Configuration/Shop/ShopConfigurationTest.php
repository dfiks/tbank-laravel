<?php

namespace DFiks\TBank\Tests\Configuration\Shop;

use DFiks\TBank\Configuration\Shop\Exceptions\ShopConfigurationException;
use DFiks\TBank\Configuration\Shop\ShopConfiguration;
use DFiks\TBank\Tests\Configuration\ConfigurationCase;

class ShopConfigurationTest extends ConfigurationCase
{
    /**
     * Возвращаем ключ конфигурации для `ShopConfiguration`.
     *
     * @return string
     */
    protected function configKey(): string
    {
        return 'tbank.shops.testing-shop';
    }

    /**
     * Получаем объект конфигурации для `ShopConfiguration`.
     *
     * @return ShopConfiguration
     */
    protected function getConfiguration(): ShopConfiguration
    {
        return new ShopConfiguration('testing-shop');
    }

    /**
     * Возвращаем валидную конфигурацию для теста.
     *
     * @return array
     */
    protected function validConfig(): array
    {
        return [
            'identifiers' => [
                'merchant_name' => 'Test Merchant',
                'merchant_id' => 12345,
                'terminal_id' => 'term123',
            ],
            'terminals' => [
                'test' => [
                    'terminal_id' => 'test123',
                    'password' => 'test_pass',
                    'http_notification' => 'https://example.com/notify',
                    'success_url' => 'https://example.com/success',
                    'error_url' => 'https://example.com/error',
                ],
                'production' => [
                    'terminal_id' => 'prod123',
                    'password' => 'prod_pass',
                    'http_notification' => false,
                    'success_url' => 'https://example.com/success',
                    'error_url' => 'https://example.com/error',
                ],
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
            'identifiers' => [
                'merchant_id' => 12345,
                'terminal_id' => 'term123',
            ],
            'terminals' => [
                'test' => [
                    'terminal_id' => 'test123',
                    'password' => 'test_pass',
                ],
                'production' => [
                    'terminal_id' => 'prod123',
                    'password' => 'prod_pass',
                ],
            ],
        ];
    }

    protected function exceptionClass(): string
    {
        return ShopConfigurationException::class;
    }
}
