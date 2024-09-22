<?php

namespace DFiks\TBank\Configuration\Shop\Dto;

class ShopIdentifiersConfig
{
    public function __construct(private readonly array $identifiers)
    {
    }

    public function getMerchantName(): ?string
    {
        return $this->identifiers['merchant_name'] ?? null;
    }

    public function getMerchantId(): ?string
    {
        return $this->identifiers['merchant_id'] ?? null;
    }

    public function getTerminalId(): ?string
    {
        return $this->identifiers['terminal_id'] ?? null;
    }
}
