<?php

namespace DFiks\TBank\Tests\Payments;

use DFiks\TBank\Core\TBankApi;
use DFiks\TBank\Payments\Enums\ApiMethods;
use DFiks\TBank\Payments\Methods\Standard\Options\GetStateOption;
use DFiks\TBank\Payments\Request\ApiRequest;
use DFiks\TBank\Payments\Response\GetStateResponse;
use DFiks\TBank\Tests\TestCase;
use DFiks\TBank\Tests\Traits\InteractWithPayment;

class GetStatePaymentTest extends TestCase
{
    use InteractWithPayment;

    public function testGetStatePayment(): void
    {
        $this->initTestShop();

        ApiRequest::fake([
            ApiMethods::GetState->value => new GetStateResponse($data = [
                'Success' => true,
                'ErrorCode' => 0,
                'TerminalKey' => 'Testing',
                'Status' => 'NEW',
                'PaymentId' => 'fake_payment_id',
                'OrderId' => 'order_123456',
                'Amount' => 10000,
                'Message' => 'OK',
                'Details' => '0',
                'Params' => [
                    'Route' => 'TCB',
                    'Source' => 'Installment',
                    'CreditAmount' => 10000,
                ],
            ]),
        ]);

        $tbankApi = new TBankApi();

        $response = $tbankApi->standard()->getState(new GetStateOption(
            'fake_payment_id'
        ));

        $this->assertInstanceOf(GetStateResponse::class, $response);
        $this->assertTrue($response->getSuccess());
        $this->assertEquals('fake_payment_id', $response->getPaymentId());
        $this->assertEquals('order_123456', $response->getOrderId());
        $this->assertEquals(['Route' => 'TCB', 'Source' => 'Installment', 'CreditAmount' => 10000], $response->getParams());
        $this->assertSame($data, $response->toArray());
    }
}
