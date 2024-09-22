<?php

namespace DFiks\TBank\Payments\Typed;

use DateTime;
use Exception;
use InvalidArgumentException;

class BirthdateType
{
    private string $birthdate;

    public function __construct(mixed $date)
    {
        $this->birthdate = $this->parseDate($date);
    }

    /**
     * Возвращает дату рождения в формате ДД.ММ.ГГГГ.
     *
     * @return string
     */
    public function getBirthdate(): string
    {
        return $this->birthdate;
    }

    /**
     * Парсит дату в формате ДД.ММ.ГГГГ из различных типов данных.
     *
     * @param  mixed                    $date
     * @throws InvalidArgumentException
     * @return string
     */
    private function parseDate(mixed $date): string
    {
        try {
            if (is_int($date)) {
                return (new DateTime())->setTimestamp($date)->format('d.m.Y');
            }

            if (is_string($date)) {
                $dateTime = new DateTime($date);

                return $dateTime->format('d.m.Y');
            }

            if ($date instanceof DateTime) {
                return $date->format('d.m.Y');
            }

            throw new InvalidArgumentException('Неверный формат даты');
        } catch (Exception $e) {
            throw new InvalidArgumentException('Неверный формат даты: ' . $e->getMessage());
        }
    }
}
