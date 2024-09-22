<?php

namespace DFiks\TBank\Configuration\Shop\Dto;

use DFiks\TBank\Payments\Enums\TaxationType;

class ShopTerminalsConfig
{
    public function __construct(private readonly array $terminals)
    {
    }

    /**
     * Получить идентификатор терминала.
     *
     * @return ?string
     */
    public function getTerminalId(): ?string
    {
        return $this->terminals['terminal_id'] ?? null;
    }

    /**
     * Получить пароль терминала.
     *
     * @return ?string
     */
    public function getPassword(): ?string
    {
        return $this->terminals['password'] ?? null;
    }

    /**
     * Получить URL для HTTP-уведомлений или false, если уведомления отключены.
     *
     * @return string|false
     */
    public function getHttpNotification(): string|false
    {
        return $this->terminals['http_notification'] ?? false;
    }

    /**
     * Получить URL страницы успеха.
     *
     * @return ?string
     */
    public function getSuccessUrl(): ?string
    {
        return $this->terminals['success_url'] ?? null;
    }

    /**
     * Получить URL страницы ошибки.
     *
     * @return ?string
     */
    public function getErrorUrl(): ?string
    {
        return $this->terminals['error_url'] ?? null;
    }

    /**
     * Получить систему налогообложения терминала.
     *
     * @return string
     */
    public function getTaxation(): string
    {
        return $this->terminals['taxation'] ?? TaxationType::UsnIncome->value;
    }
}
