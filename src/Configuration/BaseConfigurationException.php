<?php

namespace DFiks\TBank\Configuration;

use Exception;

abstract class BaseConfigurationException extends Exception
{
    private array $errors;
    private array $configData;

    public function __construct(array $errors, array $configData)
    {
        $this->errors = $errors;
        $this->configData = $configData;

        $message = $this->generateErrorMessage();

        parent::__construct($message);
    }

    /**
     * Генерация сообщения об ошибке
     * Реализация должна предоставить конкретное сообщение об ошибке.
     *
     * @return string
     */
    abstract protected function getErrorHeader(): string;

    /**
     * Создает строку сообщения с ошибками и конфигурацией.
     *
     * @return string
     */
    private function generateErrorMessage(): string
    {
        $red = "\033[31m";
        $yellow = "\033[33m";
        $green = "\033[32m";
        $reset = "\033[0m";

        $message = $red . $this->getErrorHeader() . $reset . PHP_EOL;

        foreach ($this->errors as $error) {
            $message .= $yellow . " - $error" . $reset . PHP_EOL;
        }

        $message .= $green . "\nПолученные данные конфигурации:" . $reset . PHP_EOL;
        foreach ($this->configData as $key => $value) {
            $formattedValue = is_array($value) ? json_encode($value) : $value;
            $message .= $reset . " $key: $green$formattedValue" . $reset . PHP_EOL;
        }

        return $message;
    }
}
