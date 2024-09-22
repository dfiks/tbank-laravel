<?php

namespace DFiks\TBank\Payments\Typed;

use DFiks\TBank\Payments\Enums\KassaItemType;

class Ean13SystemType
{
    private string $value;

    /**
     * Конструктор класса Ean13SystemType.
     *
     * @param string        $value  значение Ean13
     * @param KassaItemType $system система кассы
     */
    public function __construct(string $value, KassaItemType $system)
    {
        $system->validate($value);
        $this->value = $value;
    }

    /**
     * Получить значение Ean13.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
