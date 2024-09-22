<?php

namespace DFiks\TBank\Payments\Receipts\Items;

use DFiks\TBank\Payments\Enums\MeasurementUnitType;
use DFiks\TBank\Payments\Dto\AgentData;
use DFiks\TBank\Payments\Dto\SupplierInfo;
use DFiks\TBank\Payments\Enums\FfdVersionType;
use DFiks\TBank\Payments\Enums\PaymentMethodItemType;
use DFiks\TBank\Payments\Enums\PaymentObjectItemType;
use DFiks\TBank\Payments\Enums\TaxItemType;
use DFiks\TBank\Payments\Typed\AmountType;
use DFiks\TBank\Payments\Typed\Ean13SystemType;
use Illuminate\Contracts\Support\Arrayable;

class ReceiptItem implements Arrayable
{
    private static FfdVersionType $ffdVersion;

    private string $name;
    private int $price;
    private float $quantity;
    private ?PaymentMethodItemType $paymentMethod;
    private ?PaymentObjectItemType $objectItem;
    private ?TaxItemType $tax;
    private ?Ean13SystemType $ean13;
    private ?AgentData $agentData;
    private ?SupplierInfo $supplierInfo;
    private ?string $countryCode;
    private MeasurementUnitType $measurementUnit;
    private ?string $declarationNumber;

    public static function make(
        string $name,
        AmountType|int|string|float $price,
        float $quantity,
        ?PaymentMethodItemType $paymentMethod = null,
        ?PaymentObjectItemType $objectItem = null,
        ?TaxItemType $tax = TaxItemType::None,
        ?Ean13SystemType $ean13 = null,
        ?AgentData $agentData = null,
        ?SupplierInfo $supplierInfo = null,
        ?string $countryCode = null,
        ?MeasurementUnitType $measurementUnit = MeasurementUnitType::Unit,
        ?string $declarationNumber = null,
    ): self {
        $item = new self();
        $item->name = $name;
        $item->price = $price instanceof AmountType ? $price->getAmount() : AmountType::set($price)->getAmount();
        $item->quantity = $quantity;
        $item->paymentMethod = $paymentMethod;
        $item->objectItem = $objectItem;
        $item->tax = $tax;
        $item->ean13 = $ean13;
        $item->agentData = $agentData;
        $item->supplierInfo = $supplierInfo;
        $item->countryCode = $countryCode;
        $item->measurementUnit = $measurementUnit;
        $item->declarationNumber = $declarationNumber;

        return $item;
    }

    public function appendVersion(FfdVersionType $ffdVersion): self
    {
        self::$ffdVersion = $ffdVersion;

        return $this;
    }

    public function getAmount(): int
    {
        return $this->price * $this->quantity;
    }

    /**
     * Преобразование в массив в зависимости от версии ФФД.
     *
     * @return array
     */
    public function toArray(): array
    {
        return match (self::$ffdVersion) {
            FfdVersionType::Ffv105 => $this->toFfd105Array(),
            FfdVersionType::Ffv12 => $this->toFfd12Array(),
        };
    }

    /**
     * Преобразовать в массив для FFD версии 1.05.
     *
     * @return array
     */
    private function toFfd105Array(): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'amount' => $this->price * $this->quantity,
            'payment_method' => $this->paymentMethod?->value ?? PaymentMethodItemType::FullPayment->value,
            'payment_object' => $this->objectItem?->value ?? PaymentObjectItemType::Commodity->value,
            'tax' => $this->tax->value,
            'ean13' => $this->ean13?->getValue(),
            'agent_data' => $this->agentData?->toArray(),
            'supplier_info' => $this->supplierInfo?->toArray(),
        ];
    }

    /**
     * Преобразовать в массив для FFD версии 1.2.
     *
     * @return array
     */
    private function toFfd12Array(): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'amount' => $this->price * $this->quantity,
            'payment_method' => $this->paymentMethod?->value ?? PaymentMethodItemType::FullPayment->value,
            'payment_object' => $this->objectItem?->value ?? PaymentObjectItemType::Commodity->value,
            'tax' => $this->tax->value,
            'ean13' => $this->ean13?->getValue(),
            'agent_data' => $this->agentData?->toArray(),
            'supplier_info' => $this->supplierInfo?->toArray(),
            'country_code' => $this->countryCode,
            'measurement_unit' => $this->measurementUnit->value,
            'declaration_number' => $this->declarationNumber,
        ];
    }
}
