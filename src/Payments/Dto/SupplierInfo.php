<?php

namespace DFiks\TBank\Payments\Dto;

use Illuminate\Contracts\Support\Arrayable;
use InvalidArgumentException;

class SupplierInfo implements Arrayable
{
    private array $phones;
    private string $name;
    private string $inn;

    /**
     * Конструктор класса SupplierInfo.
     *
     * @param array  $phones массив телефонов поставщика
     * @param string $name   наименование поставщика
     * @param string $inn    ИНН поставщика
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $phones, string $name, string $inn)
    {
        $this->phones = $this->validatePhones($phones);
        $this->name = $this->validateName($name, $phones);
        $this->inn = $this->validateInn($inn);
    }

    /**
     * Валидация телефонов.
     *
     * @param  array                    $phones массив телефонов
     * @throws InvalidArgumentException
     * @return array
     */
    private function validatePhones(array $phones): array
    {
        foreach ($phones as $phone) {
            if (!preg_match('/^\+\d{1,19}$/', $phone)) {
                throw new InvalidArgumentException("Неверный формат телефона: $phone. Телефоны должны быть в формате +{Ц}.");
            }
        }

        return $phones;
    }

    /**
     * Валидация наименования поставщика с учетом ограничения по длине в зависимости от телефонов.
     *
     * @param  string                   $name   наименование поставщика
     * @param  array                    $phones массив телефонов
     * @throws InvalidArgumentException
     * @return string
     */
    private function validateName(string $name, array $phones): string
    {
        $totalPhoneLength = array_reduce($phones, function ($carry, $phone) {
            return $carry + strlen($phone) + 4;  // Каждый телефон плюс 4 символа.
        }, 0);

        $maxLength = 239 - $totalPhoneLength;

        if ($maxLength < 0) {
            throw new InvalidArgumentException('Суммарная длина телефонов превышает допустимое количество символов.');
        }

        if (strlen($name) > $maxLength) {
            throw new InvalidArgumentException("Наименование поставщика не может быть длиннее $maxLength символов с учетом телефонов.");
        }

        return $name;
    }

    /**
     * Валидация ИНН.
     *
     * @param  string                   $inn ИНН поставщика
     * @throws InvalidArgumentException
     * @return string
     */
    private function validateInn(string $inn): string
    {
        if (!preg_match('/^\d{10,12}$/', $inn)) {
            throw new InvalidArgumentException('ИНН должен содержать от 10 до 12 цифр.');
        }

        return $inn;
    }

    /**
     * Преобразование объекта в массив.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'phones' => $this->phones,
            'name' => $this->name,
            'inn' => $this->inn,
        ];
    }

    /**
     * Получить телефоны поставщика.
     *
     * @return array
     */
    public function getPhones(): array
    {
        return $this->phones;
    }

    /**
     * Получить наименование поставщика.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Получить ИНН поставщика.
     *
     * @return string
     */
    public function getInn(): string
    {
        return $this->inn;
    }
}
