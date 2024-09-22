<?php

namespace DFiks\TBank\Payments\Response;

use DFiks\TBank\Payments\Enums\PaymentStatus;
use DFiks\TBank\Payments\Response;

class InitResponse extends Response
{
    public function getTerminalKey(): string
    {
        return $this->data['TerminalKey'];
    }

    public function getStatus(): ?PaymentStatus
    {
        return PaymentStatus::tryFrom($this->data['Status']);
    }

    public function getPaymentId(): string
    {
        return $this->data['PaymentId'];
    }

    public function getOrderId(): string
    {
        return $this->data['OrderId'];
    }

    public function getAmount(): int
    {
        return $this->data['Amount'];
    }

    public function getPaymentURL(): string
    {
        return $this->data['PaymentURL'];
    }
}
