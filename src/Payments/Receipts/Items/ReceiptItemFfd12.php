<?php

namespace DFiks\TBank\Payments\Receipts\Items;

use DFiks\TBank\Payments\Dto\AgentData;
use DFiks\TBank\Payments\Dto\SupplierInfo;
use DFiks\TBank\Payments\Enums\PaymentMethodItemType;
use DFiks\TBank\Payments\Enums\PaymentObjectItemType;
use DFiks\TBank\Payments\Enums\TaxItemType;
use DFiks\TBank\Payments\Typed\Ean13SystemType;

class ReceiptItemFfd12 extends ReceiptItemFfd105
{
    public function __construct(
        private readonly string $name,
        private readonly int $price,
        private readonly float $quantity,
        private readonly ?PaymentMethodItemType $paymentMethod,
        private readonly ?PaymentObjectItemType $objectItem,
        private readonly ?TaxItemType $tax,
        private readonly ?Ean13SystemType $ean13,
        private readonly ?AgentData $agentData,
        private readonly ?SupplierInfo $supplierInfo,
        private readonly ?string $countryCode,
        private readonly ?string $measurementUnit,
        private readonly ?string $declarationNumber,
        private readonly ?string $customer = null,
        private readonly ?string $customerInn = null,
    ) {
        parent::__construct(
            name: $this->name,
            price: $this->price,
            quantity: $this->quantity,
            paymentMethod: $this->paymentMethod,
            objectItem: $this->objectItem,
            tax: $this->tax,
            ean13: $this->ean13,
            agentData: $this->agentData,
            supplierInfo: $this->supplierInfo,
        );
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getMeasurementUnit(): string
    {
        return $this->measurementUnit;
    }

    public function getDeclarationNumber(): ?string
    {
        return $this->declarationNumber;
    }

    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    public function getCustomerInn(): ?string
    {
        return $this->customerInn;
    }
}
