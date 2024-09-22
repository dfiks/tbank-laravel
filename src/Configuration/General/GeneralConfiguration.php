<?php

namespace DFiks\TBank\Configuration\General;

use DFiks\TBank\Configuration\BaseConfiguration;
use DFiks\TBank\Configuration\Contracts\ConfigInterface;
use DFiks\TBank\Configuration\General\Dto\GeneralConfig;
use DFiks\TBank\Configuration\General\Exceptions\GeneralConfigurationException;
use Illuminate\Support\Facades\Config;

class GeneralConfiguration extends BaseConfiguration
{
    protected function setConfiguration(): void
    {
        $this->configuration = new GeneralConfig($this->configValue());
    }

    /**
     * Возвращает общую информацию по TBankAPI.
     *
     * @return ConfigInterface|GeneralConfig
     */
    public function get(): ConfigInterface|GeneralConfig
    {
        return $this->configuration;
    }

    protected function getConfigurationExceptionClass(): string
    {
        return GeneralConfigurationException::class;
    }

    protected function configValue(): mixed
    {
        return Config::get('tbank.generals', []);
    }

    protected function rules(): array
    {
        return [
            'api_version' => 'required|string',
            'endpoints.test' => 'required|url',
            'endpoints.production' => 'required|url',
        ];
    }
}
