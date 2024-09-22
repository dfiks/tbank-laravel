<?php

namespace DFiks\TBank\Tests\Traits;

use Illuminate\Support\Facades\Config;

trait InteractWithPayment
{
    public function initTestShop(): void
    {
        Config::set([
            'tbank.shops' => [
                'testShop' => [
                    'identifiers' => [
                        'merchant_name' => 'Test Merchant',
                        'merchant_id' => 12345,
                        'terminal_id' => 'term123',
                    ],
                    'terminals' => [
                        'test' => [
                            'terminal_id' => 'test_terminal_id',
                            'password' => 'test_password',
                        ],
                        'production' => [
                            'terminal_id' => 'prod_terminal_id',
                            'password' => 'prod_password',
                        ],
                    ],
                ],
            ],
            'tbank.general' => [
                'api_version' => 'v2',
                'endpoints' => [
                    'test' => 'https://rest-api-test.tinkoff.ru',
                    'production' => 'https://securepay.tinkoff.ru',
                ],
            ],
        ]);
    }
}
