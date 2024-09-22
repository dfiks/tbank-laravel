<?php

namespace DFiks\TBank\Payments\Response;

use DFiks\TBank\Payments\Enums\PaymentStatus;
use DFiks\TBank\Payments\Response;

class CancelResponse extends Response
{
    public function getTerminalKey(): string
    {
        return $this->data['TerminalKey'];
    }

    public function getOrderId(): string
    {
        return $this->data['OrderId'];
    }

    public function getStatus(): PaymentStatus
    {
        return PaymentStatus::tryFrom($this->data['Status']);
    }

    public function getPaymentId(): string
    {
        return $this->data['PaymentId'];
    }

    public function getExternalRequestId(): string
    {
        return $this->data['ExternalRequestId'];
    }

    public function getOriginalAmount(): int
    {
        return $this->data['OriginalAmount'];
    }

    public function getNewAmount(): int
    {
        return $this->data['NewAmount'];
    }
}
