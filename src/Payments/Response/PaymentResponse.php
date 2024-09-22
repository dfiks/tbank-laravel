<?php

namespace DFiks\TBank\Payments\Response;

use DFiks\TBank\Payments\Enums\PaymentStatus;
use DFiks\TBank\Payments\Response;

class PaymentResponse extends Response
{
    public function getPaymentId(): string
    {
        return $this->data['PaymentId'];
    }

    public function amount(): int
    {
        return $this->data['Amount'];
    }

    public function status(): ?PaymentStatus
    {
        return PaymentStatus::tryFrom($this->data['Status']);
    }

    public function rrn(): ?string
    {
        return $this->data['RRN'] ?? null;
    }
}
