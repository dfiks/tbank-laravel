<?php

namespace DFiks\TBank\Payments\Enums;

/**
 * Перечисление способов расчета.
 */
enum PaymentMethodItemType: string
{
    /**
     * Полная предоплата (предоплата 100%).
     */
    case FullPrepayment = 'full_prepayment';

    /**
     * Предоплата.
     */
    case Prepayment = 'prepayment';

    /**
     * Аванс.
     */
    case Advance = 'advance';

    /**
     * Полный расчет.
     */
    case FullPayment = 'full_payment';

    /**
     * Частичный расчет и кредит.
     */
    case PartialPayment = 'partial_payment';

    /**
     * Передача в кредит.
     */
    case Credit = 'credit';

    /**
     * Оплата кредита.
     */
    case CreditPayment = 'credit_payment';

    /**
     * Получить описание способа расчета.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::FullPrepayment => 'Предоплата 100%',
            self::Prepayment => 'Предоплата',
            self::Advance => 'Аванс',
            self::FullPayment => 'Полный расчет',
            self::PartialPayment => 'Частичный расчет и кредит',
            self::Credit => 'Передача в кредит',
            self::CreditPayment => 'Оплата кредита',
        };
    }

    /**
     * Получить значение по умолчанию.
     *
     * @return self
     */
    public static function default(): self
    {
        return self::FullPayment;
    }
}
