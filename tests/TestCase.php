<?php

namespace DFiks\TBank\Tests;

use DFiks\TBank\Providers\TBankConfigurationServiceProvider;
use DFiks\TBank\Providers\TBankServiceProvider;
use Illuminate\Support\Facades\Config;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::set('tbank.default_shop', null);
    }

    protected function getPackageProviders($app): array
    {
        return [
            TBankServiceProvider::class,
            TBankConfigurationServiceProvider::class,
        ];
    }
}
