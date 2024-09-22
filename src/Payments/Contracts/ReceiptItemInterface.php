<?php

namespace DFiks\TBank\Payments\Contracts;

interface ReceiptItemInterface
{
    public function getName(): string;

    public function getPrice(): int;

    public function getQuantity(): float;

    public function getAmount(): int;

    public function getPaymentMethod(): string;

    public function getPaymentObject(): string;

    public function getTax(): string;
}
