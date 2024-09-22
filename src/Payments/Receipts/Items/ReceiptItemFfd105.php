<?php

namespace DFiks\TBank\Payments\Receipts\Items;

use DFiks\TBank\Payments\Contracts\ReceiptItemInterface;
use DFiks\TBank\Payments\Dto\AgentData;
use DFiks\TBank\Payments\Dto\SupplierInfo;
use DFiks\TBank\Payments\Enums\PaymentMethodItemType;
use DFiks\TBank\Payments\Enums\PaymentObjectItemType;
use DFiks\TBank\Payments\Enums\TaxItemType;
use DFiks\TBank\Payments\Typed\Ean13SystemType;

class ReceiptItemFfd105 implements ReceiptItemInterface
{
    public function __construct(
        private readonly string $name,
        private readonly int $price,
        private readonly float $quantity,
        private readonly ?PaymentMethodItemType $paymentMethod = null,
        private readonly ?PaymentObjectItemType $objectItem = null,
        private readonly ?TaxItemType $tax = null,
        private readonly ?Ean13SystemType $ean13 = null,
        private readonly ?AgentData $agentData = null,
        private readonly ?SupplierInfo $supplierInfo = null
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getAmount(): int
    {
        return $this->price;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod->value;
    }

    public function getPaymentObject(): string
    {
        return $this->objectItem->value;
    }

    public function getTax(): string
    {
        return $this->tax->value;
    }
}
