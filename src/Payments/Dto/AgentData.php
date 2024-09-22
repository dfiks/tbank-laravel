<?php

namespace DFiks\TBank\Payments\Dto;

use DFiks\TBank\Payments\Enums\AgentSignType;
use DFiks\TBank\Payments\Typed\PhoneType;
use InvalidArgumentException;
use Illuminate\Contracts\Support\Arrayable;

class AgentData implements Arrayable
{
    /**
     * Конструктор класса AgentData.
     *
     * @param AgentSignType $agentSign       признак агента
     * @param string|null   $operationName   наименование операции
     * @param array|null    $phones          телефоны платежного агента
     * @param array|null    $receiverPhones  телефоны оператора по приему платежей
     * @param array|null    $transferPhones  телефоны оператора перевода
     * @param string|null   $operatorName    наименование оператора перевода
     * @param string|null   $operatorAddress адрес оператора перевода
     * @param string|null   $operatorInn     ИНН оператора перевода
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        private readonly AgentSignType $agentSign,
        private readonly ?string $operationName = null,
        private readonly ?array $phones = null,
        private readonly ?array $receiverPhones = null,
        private readonly ?array $transferPhones = null,
        private readonly ?string $operatorName = null,
        private readonly ?string $operatorAddress = null,
        private readonly ?string $operatorInn = null
    ) {
        $this->validate();
    }

    /**
     * Валидация данных агента.
     *
     * @throws InvalidArgumentException
     * @return void
     */
    private function validate(): void
    {
        // Валидация наименования операции
        if (in_array($this->agentSign, [AgentSignType::BankPayingAgent, AgentSignType::BankPayingSubagent]) && empty($this->operationName)) {
            throw new InvalidArgumentException('OperationName обязателен для bank_paying_agent и bank_paying_subagent.');
        }

        // Валидация телефонов
        if (in_array($this->agentSign, [AgentSignType::BankPayingAgent, AgentSignType::BankPayingSubagent, AgentSignType::PayingAgent, AgentSignType::PayingSubagent])) {
            $this->validatePhones($this->phones, 'Phones');
        }

        if (in_array($this->agentSign, [AgentSignType::PayingAgent, AgentSignType::PayingSubagent])) {
            $this->validatePhones($this->receiverPhones, 'ReceiverPhones');
        }

        if (in_array($this->agentSign, [AgentSignType::BankPayingAgent, AgentSignType::BankPayingSubagent])) {
            $this->validatePhones($this->transferPhones, 'TransferPhones');
            $this->validateString($this->operatorName, 'OperatorName', 64);
            $this->validateString($this->operatorAddress, 'OperatorAddress', 243);
            $this->validateInn($this->operatorInn, 'OperatorInn');
        }
    }

    /**
     * Валидация телефонов.
     *
     * @param  array|null               $phones    массив телефонов
     * @param  string                   $fieldName имя поля для сообщения об ошибке
     * @throws InvalidArgumentException
     */
    private function validatePhones(?array $phones, string $fieldName): void
    {
        if (is_null($phones)) {
            throw new InvalidArgumentException("$fieldName обязателен.");
        }

        foreach ($phones as &$phone) {
            $phone = (new PhoneType($phone))->getPhone();

            if (!preg_match('/^\+\d{1,19}$/', $phone)) {
                throw new InvalidArgumentException("Неверный формат телефона в $fieldName.");
            }
        }
    }

    /**
     * Валидация строки с ограничением длины.
     *
     * @param  string|null              $value     значение строки
     * @param  string                   $fieldName имя поля для сообщения об ошибке
     * @param  int                      $maxLength максимальная длина строки
     * @throws InvalidArgumentException
     */
    private function validateString(?string $value, string $fieldName, int $maxLength): void
    {
        if (empty($value)) {
            throw new InvalidArgumentException("$fieldName обязателен.");
        }

        if (strlen($value) > $maxLength) {
            throw new InvalidArgumentException("$fieldName не может быть длиннее $maxLength символов.");
        }
    }

    /**
     * Валидация ИНН.
     *
     * @param  string|null              $inn       ИНН оператора перевода
     * @param  string                   $fieldName имя поля для сообщения об ошибке
     * @throws InvalidArgumentException
     */
    private function validateInn(?string $inn, string $fieldName): void
    {
        if (empty($inn) || !preg_match('/^\d{10,12}$/', $inn)) {
            throw new InvalidArgumentException("Неверный формат ИНН в $fieldName.");
        }
    }

    /**
     * Преобразование объекта в массив.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'agent_sign' => $this->agentSign->value,
            'operation_name' => $this->operationName,
            'phones' => $this->phones,
            'receiver_phones' => $this->receiverPhones,
            'transfer_phones' => $this->transferPhones,
            'operator_name' => $this->operatorName,
            'operator_address' => $this->operatorAddress,
            'operator_inn' => $this->operatorInn,
        ];
    }
}
