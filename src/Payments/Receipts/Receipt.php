<?php

namespace DFiks\TBank\Payments\Receipts;

use DFiks\TBank\Payments\Enums\CitizenshipType;
use DFiks\TBank\Payments\Enums\DocumentCodeType;
use DFiks\TBank\Payments\Enums\FfdVersionType;
use DFiks\TBank\Payments\Enums\TaxationType;
use DFiks\TBank\Payments\Receipts\Items\ReceiptItem;
use DFiks\TBank\Payments\Typed\BirthdateType;
use DFiks\TBank\Payments\Typed\PhoneType;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class Receipt implements Arrayable
{
    private array $items = [];
    private ?string $email = null;
    private ?string $phone = null;
    private ?string $taxation = null;
    private ?string $birthdate = null;
    private ?int $citizenship = null;
    private ?int $documentCode = null;
    private ?string $documentData = null;
    private ?string $address = null;
    private ?string $customer = null;
    private ?string $customerInn = null;
    private ?array $data = [];

    public function __construct(private readonly FfdVersionType $ffdVersion)
    {
    }

    public static function make(FfdVersionType $version = FfdVersionType::Ffv105): self
    {
        return new self($version);
    }

    public function addItems(ReceiptItem ...$receiptItems): self
    {
        foreach ($receiptItems as $receiptItem) {
            $receiptItem->appendVersion($this->ffdVersion);
        }

        $this->items = array_merge($this->items, $receiptItems);

        return $this;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPhone(PhoneType $phone): self
    {
        $this->phone = $phone->getPhone();

        return $this;
    }

    public function setTaxation(TaxationType $taxation): self
    {
        if (!$this->taxation) {
            $this->taxation = $taxation->value;
        }

        return $this;
    }

    public function setBirthdate(BirthdateType $birthdate): self
    {
        $this->birthdate = $birthdate->getBirthdate();

        return $this;
    }

    public function setCitizenship(CitizenshipType|int $citizenshipType): self
    {
        if (is_int($citizenshipType)) {
            $this->citizenship = $citizenshipType;
        } else {
            $this->citizenship = $citizenshipType->value;
        }

        return $this;
    }

    public function setDocumentCode(DocumentCodeType|int $documentCode): self
    {
        if (is_int($documentCode)) {
            $this->documentCode = $documentCode;
        } else {
            $this->documentCode = $documentCode->value;
        }

        return $this;
    }

    public function setDocumentData(string $documentData): self
    {
        $this->documentData = $documentData;

        return $this;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function setCustomer(string $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function setCustomerInn(string $customerInn): self
    {
        $this->customerInn = $customerInn;

        return $this;
    }

    public function getTotalAmount(): int
    {
        $totalAmount = 0;

        foreach ($this->items as $item) {
            $totalAmount += $item->getAmount();
        }

        return $totalAmount;
    }

    /**
     * Преобразование объекта в массив.
     *
     * @return array
     */
    public function toArray(): array
    {
        $data = collect([
            'FfdVersion' => $this->ffdVersion->value,
            'Items' => collect($this->items)
                ->map(
                    fn ($item) => collect($item->toArray())
                    ->filter(fn ($value) => $value !== null)
                    ->keyBy(fn ($value, $key) => ucfirst(Str::camel($key)))
                    ->toArray()
                ),
            'Data' => [
                'Email' => $this->email,
                'Phone' => $this->phone,
                ...$this->data,
            ],
            'Taxation' => $this->taxation,
        ]);

        if ($this->ffdVersion === FfdVersionType::Ffv12) {
            $clientInfo = collect([
                'Birthdate' => $this->birthdate,
                'Citizenship' => $this->citizenship,
                'DocumentCode' => $this->documentCode,
                'DocumentData' => $this->documentData,
                'Address' => $this->address,
            ])->filter(fn ($value) => $value !== null);

            if ($clientInfo->isNotEmpty()) {
                $data->put('ClientInfo', $clientInfo->toArray());
            }
            $data->put('Customer', $this->customer);
            $data->put('CustomerInn', $this->customerInn);
        }

        return $data->filter(fn ($value) => $value !== null)->toArray();
    }
}
