<?php

namespace DFiks\TBank\Payments\Typed;

use InvalidArgumentException;

class PhoneType
{
    private string $phone;

    /**
     * Конструктор, принимает номер телефона и приводит его к формату +{Ц}.
     *
     * @param mixed $phone
     */
    public function __construct(mixed $phone)
    {
        $this->phone = $this->formatPhone($phone);
    }

    /**
     * Возвращает форматированный номер телефона.
     *
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Форматирует телефонный номер в формат +{Ц}.
     *
     * @param  mixed                    $phone
     * @throws InvalidArgumentException
     * @return string
     */
    private function formatPhone(mixed $phone): string
    {
        if (!is_string($phone) && !is_numeric($phone)) {
            throw new InvalidArgumentException('Телефон должен быть строкой или числом');
        }

        $digits = preg_replace('/[^\d]/', '', (string) $phone);

        if (str_starts_with($digits, '8') && strlen($digits) === 11) {
            $digits = '7' . substr($digits, 1);
        }

        if (strlen($digits) < 10 || strlen($digits) > 15) {
            throw new InvalidArgumentException('Некорректный формат номера телефона');
        }

        return '+' . $digits;
    }
}
