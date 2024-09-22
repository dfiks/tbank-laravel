<?php

namespace DFiks\TBank\Tests\Payments;

use DFiks\TBank\Core\TBankApi;
use DFiks\TBank\Payments\Enums\ApiMethods;
use DFiks\TBank\Payments\Methods\Standard\Options\InitOption;
use DFiks\TBank\Payments\Receipts\Items\ReceiptItem;
use DFiks\TBank\Payments\Receipts\Receipt;
use DFiks\TBank\Payments\Request\ApiRequest;
use DFiks\TBank\Payments\Response\InitResponse;
use DFiks\TBank\Tests\TestCase;
use DFiks\TBank\Tests\Traits\InteractWithPayment;

class InitPaymentTest extends TestCase
{
    use InteractWithPayment;

    public function testInitPayment(): void
    {
        $this->initTestShop();

        ApiRequest::fake([
            ApiMethods::Init->value => new InitResponse($data = [
                'Success' => true,
                'ErrorCode' => 0,
                'TerminalKey' => 'Testing',
                'Status' => 'NEW',
                'PaymentId' => 'fake_payment_id',
                'OrderId' => 'order_123456',
                'Amount' => 10000,
                'PaymentURL' => 'https://securepayments-test.tcsbank.ru/Qveu3Qz1',
            ]),
        ]);

        $tbankApi = new TBankApi();

        $response = $tbankApi->standard()->init(new InitOption(
            Receipt::make()->addItems(
                ReceiptItem::make('Test', 9.99, 51),
            ),
            description: 'Hello world'
        ));

        $this->assertInstanceOf(InitResponse::class, $response);
        $this->assertTrue($response->getSuccess());
        $this->assertEquals('fake_payment_id', $response->getPaymentId());
        $this->assertEquals('order_123456', $response->getOrderId());
        $this->assertSame($data, $response->toArray());
    }
}
