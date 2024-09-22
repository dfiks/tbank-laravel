<?php

namespace DFiks\TBank\Payments\Enums;

use InvalidArgumentException;

/**
 * Перечисление кассовых систем.
 */
enum KassaItemType: string
{
    case AtolOnline = 'atol_online';
    case CloudKassir = 'cloud_kassir';
    case OrangeData = 'orange_data';

    /**
     * Выполнить валидацию для переданной системы кассы.
     *
     * @param  string                   $value
     * @throws InvalidArgumentException
     * @return void
     */
    public function validate(string $value): void
    {
        match ($this) {
            self::AtolOnline => $this->validateAtolOnline($value),
            self::CloudKassir => $this->validateCloudKassir($value),
            self::OrangeData => $this->validateOrangeData($value),
        };
    }

    /**
     * Валидация для системы АТОЛ Онлайн.
     *
     * @param  string                   $value
     * @throws InvalidArgumentException
     * @return void
     */
    private function validateAtolOnline(string $value): void
    {
        if (!preg_match('/^([a-fA-F0-9]{2}\s){0,31}[a-fA-F0-9]{2}$/', $value)) {
            throw new InvalidArgumentException('Неверный параметр Ean13 для системы АТОЛ Онлайн.');
        }
    }

    /**
     * Валидация для системы CloudKassir.
     *
     * @param  string                   $value
     * @throws InvalidArgumentException
     * @return void
     */
    private function validateCloudKassir(string $value): void
    {
        if (!preg_match('/^[0-9A-F]{8,300}$/i', $value) || strlen($value) % 2 !== 0) {
            throw new InvalidArgumentException('Неверный параметр Ean13 для системы CloudKassir.');
        }
    }

    /**
     * Валидация для системы OrangeData.
     *
     * @param  string                   $value
     * @throws InvalidArgumentException
     * @return void
     */
    private function validateOrangeData(string $value): void
    {
        if (base64_decode($value, true) === false || strlen(base64_decode($value, true)) < 8 || strlen(base64_decode($value, true)) > 32) {
            throw new InvalidArgumentException('Неверный параметр Ean13 для системы OrangeData.');
        }
    }
}
