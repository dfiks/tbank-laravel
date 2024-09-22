<?php

namespace DFiks\TBank\Payments\Response;

use DFiks\TBank\Payments\Response;

class CheckOrderResponse extends Response
{
    public function getTerminalKey(): string
    {
        return $this->data['TerminalKey'];
    }

    public function getOrderId(): string
    {
        return $this->data['OrderId'];
    }

    public function getPayment(): PaymentResponse
    {
        return new PaymentResponse($this->data['Payments']);
    }
}
