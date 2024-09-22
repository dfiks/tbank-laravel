<?php

namespace DFiks\TBank\Configuration\Shop\Dto;

use DFiks\TBank\Configuration\Contracts\ConfigInterface;
use DFiks\TBank\Configuration\Enums\EnvironmentType;
use DFiks\TBank\Core\TBankApi;

class ShopConfig implements ConfigInterface
{
    public function __construct(private readonly array $shopConfig, private readonly string $shopName)
    {
    }

    /**
     * Получить название магазина.
     *
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->shopName;
    }

    /**
     * Получить URL магазина.
     *
     * @return ?string
     */
    public function getUrl(): ?string
    {
        return $this->getAttribute('url');
    }

    public function getIdentifiers(): ShopIdentifiersConfig
    {
        return new ShopIdentifiersConfig($this->getAttribute('identifiers'));
    }

    /**
     * Получить конфигурацию терминала по типу (test или production).
     *
     * @param  ?EnvironmentType    $type
     * @return ShopTerminalsConfig
     */
    public function getTerminals(?EnvironmentType $type = null): ShopTerminalsConfig
    {
        if (is_null($type)) {
            $type = TBankApi::isDebug() ? EnvironmentType::Test : EnvironmentType::Production;
        }

        return new ShopTerminalsConfig($this->getAttribute('terminals')[$type->value]);
    }

    private function getAttribute(string $dotKey): mixed
    {
        return $this->shopConfig[$dotKey] ?? null;
    }
}
