<?php

namespace DFiks\TBank\Configuration\Shop;

use DFiks\TBank\Configuration\BaseConfiguration;
use DFiks\TBank\Configuration\Contracts\ConfigInterface;
use DFiks\TBank\Configuration\Shop\Dto\ShopConfig;
use DFiks\TBank\Configuration\Shop\Exceptions\ShopConfigurationException;
use Illuminate\Support\Facades\Config;

class ShopConfiguration extends BaseConfiguration
{
    public function __construct(private readonly string $shopName)
    {
        parent::__construct();
    }

    protected function setConfiguration(): void
    {
        $this->configuration = new ShopConfig($this->configValue(), $this->shopName);
    }

    /**
     * Возвращает конфигурацию магазина.
     *
     * @return ConfigInterface|ShopConfig
     */
    public function get(): ConfigInterface|ShopConfig
    {
        return $this->configuration;
    }

    protected function getConfigurationExceptionClass(): string
    {
        return ShopConfigurationException::class;
    }

    protected function configValue(): mixed
    {
        return Config::get(sprintf('tbank.shops.%s', $this->shopName));
    }

    protected function rules(): array
    {
        return [
            'identifiers.merchant_name' => 'required|string',
            'identifiers.merchant_id' => 'required|sometimes',
            'identifiers.terminal_id' => 'required|sometimes',
            'terminals.test.terminal_id' => 'required|string',
            'terminals.test.password' => 'required|string',
            'terminals.test.http_notification' => 'nullable|sometimes',
            'terminals.test.success_url' => 'nullable|url',
            'terminals.test.error_url' => 'nullable|url',
            'terminals.production.terminal_id' => 'required|string',
            'terminals.production.password' => 'required|string',
            'terminals.production.http_notification' => 'nullable|sometimes',
            'terminals.production.success_url' => 'nullable|url',
            'terminals.production.error_url' => 'nullable|url',
        ];
    }
}
