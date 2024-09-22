<?php

namespace DFiks\TBank\Tests\Core;

use DFiks\TBank\Configuration\Shop\ShopConfiguration;
use DFiks\TBank\Configuration\General\GeneralConfiguration;
use DFiks\TBank\Configuration\Shop\Exceptions\ShopConfigurationNotFoundException;
use DFiks\TBank\Core\TBankApi;
use DFiks\TBank\Tests\TestCase;
use Generator;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\DataProvider;

class TBankApiInitTest extends TestCase
{
    /**
     * Тест успешной инициализации API с данными провайдера.
     */
    #[DataProvider('configurationProvider')]
    public function testApiInitWithShopName(array $configData, ?string $shopName, string $expectedShopName): void
    {
        // Устанавливаем конфигурацию для теста из провайдера
        Config::set($configData);

        // Инициализация API
        $api = $shopName ? TBankApi::init($shopName) : new TBankApi();
        $this->assertInstanceOf(TBankApi::class, $api);

        // Проверка, что конфигурация магазина корректно загружена
        $shopConfig = TBankApi::getShopConfiguration();
        $this->assertInstanceOf(ShopConfiguration::class, $shopConfig);
        $this->assertEquals($expectedShopName, $shopConfig->get()->getName());

        // Проверка, что конфигурация общих настроек корректно загружена
        $generalConfig = TBankApi::getGeneralConfiguration();
        $this->assertInstanceOf(GeneralConfiguration::class, $generalConfig);
        $this->assertEquals('v2', $generalConfig->get()->getApiVersion());
    }

    /**
     * Тест выброса исключения, если нет конфигурации магазинов.
     */
    public function testApiInitThrowsExceptionWhenNoConfigurations(): void
    {
        // Удаляем конфигурацию
        Config::set('tbank.shops', []);

        // Ожидаем, что будет выброшено исключение ShopConfigurationNotFoundException
        $this->expectException(ShopConfigurationNotFoundException::class);
        TBankApi::init('nonExistentShop');
    }

    /**
     * Тест выброса исключения, если нет конкретной конфигурации магазина.
     */
    public function testApiInitThrowsExceptionWhenNotFound(): void
    {
        Config::set('tbank.shops', ['testing' => []]);
        Config::set('tbank.default_shop', 'something');

        $this->expectException(ShopConfigurationNotFoundException::class);
        TBankApi::init('nonExistentShop');
    }

    /**
     * Тест работы режима отладки (debug).
     */
    public function testIsDebugMode(): void
    {
        // Устанавливаем режим отладки в конфигурации
        Config::set('tbank.debug', true);
        $this->assertTrue(TBankApi::isDebug());

        // Отключаем режим отладки
        Config::set('tbank.debug', false);
        $this->assertFalse(TBankApi::isDebug());
    }

    public static function configurationProvider(): Generator
    {
        $terminals = [
            'test' => [
                'terminal_id' => 'test_terminal_id',
                'password' => 'test_password',
            ],
            'production' => [
                'terminal_id' => 'prod_terminal_id',
                'password' => 'prod_password',
            ],
        ];

        $firstShopIdentifiers = [
            'merchant_name' => 'First Merchant',
            'merchant_id' => 11111,
            'terminal_id' => 'first_term_id',
        ];

        $secondShopIdentifiers = [
            'merchant_name' => 'Second Merchant',
            'merchant_id' => 22222,
            'terminal_id' => 'second_term_id',
        ];

        $testShopIdentifiers = [
            'merchant_name' => 'Test Merchant',
            'merchant_id' => 12345,
            'terminal_id' => 'term123',
        ];

        yield 'single shop' => [
            [
                'tbank.shops' => [
                    'testShop' => [
                        'identifiers' => $testShopIdentifiers,
                        'terminals' => $terminals,
                    ],
                ],
                'tbank.general' => [
                    'api_version' => 'v2',
                    'endpoints' => [
                        'test' => 'https://rest-api-test.tinkoff.ru',
                        'production' => 'https://securepay.tinkoff.ru',
                    ],
                ],
            ],
            'testShop',
            'testShop',
        ];

        yield 'multiple shops' => [
            [
                'tbank.shops' => [
                    'firstShop' => [
                        'identifiers' => $firstShopIdentifiers,
                        'terminals' => $terminals,
                    ],
                    'secondShop' => [
                        'identifiers' => $secondShopIdentifiers,
                        'terminals' => $terminals,
                    ],
                ],
                'tbank.general' => [
                    'api_version' => 'v2',
                    'endpoints' => [
                        'test' => 'https://rest-api-test.tinkoff.ru',
                        'production' => 'https://securepay.tinkoff.ru',
                    ],
                ],
            ],
            null,
            'firstShop',
        ];
    }
}
