<?php

namespace DFiks\TBank\Tests\Payments;

use DFiks\TBank\Core\TBankApi;
use DFiks\TBank\Payments\Enums\ApiMethods;
use DFiks\TBank\Payments\Methods\Standard\Options\CheckOrderOption;
use DFiks\TBank\Payments\Request\ApiRequest;
use DFiks\TBank\Payments\Response\CheckOrderResponse;
use DFiks\TBank\Payments\Response\PaymentResponse;
use DFiks\TBank\Tests\TestCase;
use DFiks\TBank\Tests\Traits\InteractWithPayment;

class CheckOrderPaymentTest extends TestCase
{
    use InteractWithPayment;

    public function testGetStatePayment(): void
    {
        $this->initTestShop();
        ApiRequest::fake([
            ApiMethods::CheckOrder->value => new CheckOrderResponse($data = [
                'Success' => true,
                'ErrorCode' => 0,
                'TerminalKey' => 'Testing',
                'OrderId' => 'order_123456',
                'Message' => 'OK',
                'Details' => 'None',
                'Payments' => [
                    'PaymentId' => 'payment_123456',
                    'Amount' => 123123,
                    'Status' => 'NEW',
                    'RRN' => '4182491',
                    'Success' => 'true',
                    'ErrorCode' => 0,
                    'Message' => 'None',
                ],
            ]),
        ]);

        $tbankApi = new TBankApi();

        $response = $tbankApi->standard()->checkOrder(new CheckOrderOption(
            'order_123456'
        ));

        $this->assertInstanceOf(CheckOrderResponse::class, $response);
        $this->assertTrue($response->getSuccess());
        $this->assertEquals('order_123456', $response->getOrderId());
        $this->assertInstanceOf(PaymentResponse::class, $response->getPayment());
        $this->assertSame($data, $response->toArray());
    }
}
