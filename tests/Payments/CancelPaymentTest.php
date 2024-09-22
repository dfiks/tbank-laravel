<?php

namespace DFiks\TBank\Tests\Payments;

use DFiks\TBank\Core\TBankApi;
use DFiks\TBank\Payments\Enums\ApiMethods;
use DFiks\TBank\Payments\Methods\Standard\Options\CancelOption;
use DFiks\TBank\Payments\Request\ApiRequest;
use DFiks\TBank\Payments\Response\CancelResponse;
use DFiks\TBank\Payments\Response\CheckOrderResponse;
use DFiks\TBank\Tests\TestCase;
use DFiks\TBank\Tests\Traits\InteractWithPayment;

class CancelPaymentTest extends TestCase
{
    use InteractWithPayment;

    public function testGetStatePayment(): void
    {
        $this->initTestShop();

        ApiRequest::fake([
            ApiMethods::Cancel->value => new CheckOrderResponse($data = [
                'Success' => true,
                'ErrorCode' => 0,
                'TerminalKey' => 'Testing',
                'OrderId' => 'order_123456',
                'Status' => 'REVERSED',
                'Message' => 'OK',
                'Details' => 'None',
                'OriginalAmount' => 13000,
                'NewAmount' => 13000,
                'ExternalRequestId' => '124128491274',
                'PaymentId' => '123',
            ]),
        ]);

        $tbankApi = new TBankApi();

        $response = $tbankApi->standard()->cancel(new CancelOption(
            '123'
        ));

        $this->assertInstanceOf(CancelResponse::class, $response);
        $this->assertTrue($response->getSuccess());
        $this->assertEquals('order_123456', $response->getOrderId());
        $this->assertEquals('13000', $response->getNewAmount());
        $this->assertSame($data, $response->toArray());
    }
}
