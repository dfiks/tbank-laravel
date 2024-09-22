<?php

namespace DFiks\TBank\Configuration\General\Dto;

use DFiks\TBank\Configuration\Contracts\ConfigInterface;
use DFiks\TBank\Configuration\Enums\EnvironmentType;
use DFiks\TBank\Core\TBankApi;
use Illuminate\Support\Facades\Config;

class GeneralConfig implements ConfigInterface
{
    public function __construct(private readonly array $generalConfig)
    {
    }

    /**
     * Получить версию API.
     *
     * @return ?string
     */
    public function getApiVersion(): ?string
    {
        return $this->generalConfig['api_version'] ?? null;
    }

    /**
     * Получить значение endpoint.
     */
    public function getEndpoint(?EnvironmentType $type = null): ?string
    {
        if (is_null($type)) {
            $type = TBankApi::isDebug() ? EnvironmentType::Test->value : EnvironmentType::Production->value;
        }

        if (Config::get('tbank.testing_tbank')) {
            return trim($this->generalConfig['endpoints']['production']);
        }

        return trim($this->generalConfig['endpoints'][$type], '/') ?? null;
    }
}
