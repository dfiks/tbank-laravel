<?php

namespace DFiks\TBank\Payments\Enums;

/**
 * Перечисление ставок НДС.
 */
enum TaxItemType: string
{
    /**
     * Без НДС.
     */
    case None = 'none';

    /**
     * НДС по ставке 0%.
     */
    case Vat0 = 'vat0';

    /**
     * НДС по ставке 10%.
     */
    case Vat10 = 'vat10';

    /**
     * НДС по ставке 20%.
     */
    case Vat20 = 'vat20';

    /**
     * НДС чека по расчетной ставке 10/110.
     */
    case Vat110 = 'vat110';

    /**
     * НДС чека по расчетной ставке 20/120.
     */
    case Vat120 = 'vat120';

    /**
     * Получить описание ставки НДС.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::None => 'Без НДС',
            self::Vat0 => 'НДС по ставке 0%',
            self::Vat10 => 'НДС по ставке 10%',
            self::Vat20 => 'НДС по ставке 20%',
            self::Vat110 => 'НДС чека по расчетной ставке 10/110',
            self::Vat120 => 'НДС чека по расчетной ставке 20/120',
        };
    }

    /**
     * Получить значение по умолчанию.
     *
     * @return self
     */
    public static function default(): self
    {
        return self::None;
    }
}
