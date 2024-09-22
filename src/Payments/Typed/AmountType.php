<?php

namespace DFiks\TBank\Payments\Typed;

use Illuminate\Support\Str;
use InvalidArgumentException;

class AmountType
{
    public function __construct(private readonly int $amount)
    {
    }

    public static function set(mixed $amount): self
    {
        return new self(
            self::resolveAmount($amount)
        );
    }

    /**
     * Возвращает обработанное значение.
     *
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Определяет тип данных и вызывает соответствующий метод.
     *
     * @param  mixed $amount
     * @return int
     */
    private static function resolveAmount(mixed $amount): int
    {
        return match (true) {
            is_int($amount) => static::fromInt($amount),
            is_float($amount) => static::fromFloat($amount),
            is_string($amount) => static::fromString($amount),
            default => throw new InvalidArgumentException('Unsupported amount type'),
        };
    }

    /**
     * Обрабатывает сумму как целое число.
     *
     * @param  int $amount
     * @return int
     */
    private static function fromInt(int $amount): int
    {
        return $amount * 100;
    }

    /**
     * Обрабатывает сумму как число с плавающей точкой.
     *
     * @param  float $amount
     * @return int
     */
    private static function fromFloat(float $amount): int
    {
        return (int) ($amount * 100); // Преобразуем в целые копейки
    }

    /**
     * Обрабатывает сумму как строку.
     *
     * @param  string $amount
     * @return int
     */
    private static function fromString(string $amount): int
    {
        if (Str::contains($amount, [',', '.'])) {
            return static::fromFloat((float) str_replace(',', '.', $amount));
        }

        return static::fromInt((int) $amount);
    }
}
