<?php

namespace DFiks\TBank\Tests\Configuration;

use DFiks\TBank\Configuration\Contracts\ConfigurationInterface;
use DFiks\TBank\Tests\TestCase;
use Illuminate\Support\Facades\Config;

abstract class ConfigurationCase extends TestCase
{
    /**
     * Получить конфигурацию для теста.
     * Этот метод должен быть реализован в классах-наследниках, чтобы возвращать объект конфигурации.
     *
     * @return ConfigurationInterface
     */
    abstract protected function getConfiguration(): ConfigurationInterface;

    /**
     * Получить массив валидной конфигурации для теста.
     * Этот метод должен быть реализован в классах-наследниках, чтобы возвращать валидную конфигурацию.
     *
     * @return array
     */
    abstract protected function validConfig(): array;

    /**
     * Получить массив невалидной конфигурации для теста.
     * Этот метод должен быть реализован в классах-наследниках, чтобы возвращать невалидную конфигурацию.
     *
     * @return array
     */
    abstract protected function invalidConfig(): array;

    /**
     * Класс ошибки при несоответствии структуры конфигурации.
     *
     * @return string
     */
    abstract protected function exceptionClass(): string;

    /**
     * Тест, который проверяет валидность конфигурации.
     */
    public function testValidConfiguration(): void
    {
        Config::set($this->configKey(), $this->validConfig());

        $config = $this->getConfiguration();

        $this->assertInstanceOf(ConfigurationInterface::class, $config);
    }

    /**
     * Тест, который проверяет выброс исключения при невалидной конфигурации.
     */
    public function testInvalidConfiguration(): void
    {
        Config::set($this->configKey(), $this->invalidConfig());

        $this->expectException($this->exceptionClass());

        $this->getConfiguration();
    }

    /**
     * Возвращает ключ конфигурации для теста.
     *
     * @return string
     */
    abstract protected function configKey(): string;
}
