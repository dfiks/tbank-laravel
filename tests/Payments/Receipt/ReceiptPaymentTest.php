<?php

namespace DFiks\TBank\Tests\Payments\Receipt;

use DFiks\TBank\Payments\Enums\CitizenshipType;
use DFiks\TBank\Payments\Enums\DocumentCodeType;
use DFiks\TBank\Payments\Enums\FfdVersionType;
use DFiks\TBank\Payments\Enums\MeasurementUnitType;
use DFiks\TBank\Payments\Receipts\Items\ReceiptItem;
use DFiks\TBank\Payments\Receipts\Receipt;
use DFiks\TBank\Payments\Typed\BirthdateType;
use DFiks\TBank\Payments\Typed\PhoneType;
use DFiks\TBank\Tests\TestCase;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;

class ReceiptPaymentTest extends TestCase
{
    #[DataProvider('receiptDataProvider')]
    public function testReceiptBuild(FfdVersionType $ffdVersion, array $items, array $additionalFields, array $expected): void
    {
        // Создание объекта Receipt с элементами
        $receipt = Receipt::make($ffdVersion)
            ->addItems(
                ...array_map(fn ($item) => ReceiptItem::make(...$item), $items)
            );

        // Добавляем дополнительные поля (например, Email, Phone, Customer и т.д.)
        foreach ($additionalFields as $field => $value) {
            $method = 'set' . ucfirst($field);
            if (method_exists($receipt, $method)) {
                $receipt->$method($value);
            }
        }

        // Получаем массив данных из объекта Receipt
        $data = $receipt->toArray();

        // Проверка основной версии FFD
        $this->assertEquals($expected['FfdVersion'], $data['FfdVersion']);

        // Проверка элементов чека
        $this->assertItems($items, $data['Items'], $ffdVersion);

        // Проверка дополнительных полей
        $this->assertFields($data, $expected);
    }

    /**
     * Проверка элементов чека.
     *
     * @param array          $items
     * @param array          $dataItems
     * @param FfdVersionType $ffdVersion
     */
    private function assertItems(array $items, array $dataItems, FfdVersionType $ffdVersion): void
    {
        $this->assertCount(count($items), $dataItems);

        foreach ($items as $index => $item) {
            $this->assertEquals($item['name'], $dataItems[$index]['Name']);
            $this->assertEquals($item['price'] * 100, $dataItems[$index]['Price']);
            $this->assertEquals($item['quantity'], $dataItems[$index]['Quantity']);
            $this->assertEquals($item['price'] * $item['quantity'] * 100, $dataItems[$index]['Amount']);

            if ($ffdVersion === FfdVersionType::Ffv12) {
                $this->assertSame($item['measurementUnit']->value, $dataItems[$index]['MeasurementUnit']);
                $this->assertSame($item['declarationNumber'], $dataItems[$index]['DeclarationNumber']);
            } else {
                $this->assertArrayNotHasKey('MeasurementUnit', $dataItems[$index]);
                $this->assertArrayNotHasKey('DeclarationNumber', $dataItems[$index]);
            }
        }
    }

    /**
     * Проверка дополнительных полей.
     *
     * @param array $data
     * @param array $expected
     */
    private function assertFields(array $data, array $expected): void
    {
        foreach ($expected as $field => $expectedValue) {
            if (in_array($field, ['FfdVersion', 'ItemsCount'])) {
                continue;
            }
            $this->assertArrayHasKey($field, $data);
            $this->assertEquals($expectedValue, $data[$field]);
        }
    }

    /**
     * Тест на пустые элементы в чеке.
     */
    public function testEmptyItems(): void
    {
        $receipt = Receipt::make();
        $data = $receipt->toArray();

        $this->assertArrayHasKey('Items', $data);
        $this->assertEmpty($data['Items']);
    }

    /**
     * Data provider для тестов.
     *
     * @return Generator
     */
    public static function receiptDataProvider(): Generator
    {
        $items = [
            [
                'name' => 'Item 1',
                'price' => 1000,
                'quantity' => 2,
                'measurementUnit' => MeasurementUnitType::Day,
                'declarationNumber' => 'RU98412849214',
            ],
            [
                'name' => 'Item 2',
                'price' => 500,
                'quantity' => 3,
                'measurementUnit' => MeasurementUnitType::Centimeter,
                'declarationNumber' => 'RU98412849214',
            ],
        ];

        $additionalFields = [
            'Customer' => 'Test Customer',
            'CustomerInn' => '123',
            'Email' => 'test@example.com',
            'Phone' => new PhoneType('+1234567890'),
            'Birthdate' => new BirthdateType('15.04.1992'),
            'Citizenship' => CitizenshipType::Russia,
            'DocumentCode' => DocumentCodeType::RussianPassport,
            'DocumentData' => '00 00 000000',
            'Address' => 'Address',
        ];

        yield 'Version FFD 1.05' => [
            'ffdVersion' => FfdVersionType::Ffv105,
            'items' => $items,
            'additionalFields' => $additionalFields,
            'expected' => [
                'FfdVersion' => FfdVersionType::Ffv105->value,
                'Data' => [
                    'Email' => $additionalFields['Email'],
                    'Phone' => $additionalFields['Phone']->getPhone(),
                ],
            ],
        ];

        yield 'Version FFD 1.2' => [
            'ffdVersion' => FfdVersionType::Ffv12,
            'items' => $items,
            'additionalFields' => $additionalFields,
            'expected' => [
                'Customer' => $additionalFields['Customer'],
                'FfdVersion' => FfdVersionType::Ffv12->value,
                'Data' => [
                    'Email' => $additionalFields['Email'],
                    'Phone' => $additionalFields['Phone']->getPhone(),
                ],
                'CustomerInn' => $additionalFields['CustomerInn'],
                'ClientInfo' => [
                    'Birthdate' => $additionalFields['Birthdate']->getBirthdate(),
                    'Citizenship' => $additionalFields['Citizenship']->value,
                    'DocumentCode' => $additionalFields['DocumentCode']->value,
                    'DocumentData' => $additionalFields['DocumentData'],
                    'Address' => $additionalFields['Address'],
                ],
            ],
        ];
    }
}
