<?php

namespace DFiks\TBank\Configuration;

use DFiks\TBank\Configuration\Contracts\ConfigInterface;
use DFiks\TBank\Configuration\Contracts\ConfigurationInterface;
use Exception;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

/**
 * Абстрактный класс BaseConfiguration, который является базовым для всех конфигураций.
 * Он обеспечивает основные механизмы для валидации и установки конфигурации.
 */
abstract class BaseConfiguration implements ConfigurationInterface
{
    /**
     * @var ConfigInterface объект, который будет хранить валидированную конфигурацию
     */
    protected ConfigInterface $configuration;

    /**
     * Метод для получения конфигурации.
     * Этот метод должен быть реализован в классах-наследниках, чтобы возвращать
     * объект конфигурации, который реализует интерфейс ConfigInterface.
     *
     * @return ConfigInterface возвращает объект конфигурации
     */
    abstract public function get(): ConfigInterface;

    /**
     * Метод для получения класса исключений, связанных с конфигурацией.
     * Этот метод должен быть реализован в классах-наследниках и должен возвращать
     * имя класса исключения, который будет использован при ошибках валидации.
     *
     * @return string имя класса исключения
     */
    abstract protected function getConfigurationExceptionClass(): string;

    /**
     * Метод для получения правил валидации конфигурации.
     * Каждый класс-наследник должен реализовать этот метод, чтобы возвращать массив
     * правил для валидации данных конфигурации.
     *
     * @return array массив правил валидации
     */
    abstract protected function rules(): array;

    /**
     * Метод для получения значений конфигурации.
     * Этот метод должен быть реализован в классах-наследниках и возвращать конфигурацию в виде массива.
     *
     * @return mixed массив значений конфигурации
     */
    abstract protected function configValue(): mixed;

    /**
     * Метод для установки конфигурации.
     * В этом методе должна быть установлена конфигурация в виде объекта,
     * реализующего интерфейс ConfigInterface.
     *
     * @return void
     */
    abstract protected function setConfiguration(): void;

    /**
     * Конструктор класса BaseConfiguration.
     * В конструкторе происходит валидация конфигурации и установка объекта конфигурации.
     */
    public function __construct()
    {
        $this->validateConfiguration($this->configValue(), $this->rules());
        $this->setConfiguration();
    }

    /**
     * Метод для валидации конфигурации.
     * Этот метод использует Laravel Validator для проверки конфигурационных данных
     * в соответствии с переданными правилами. Если валидация не проходит, выбрасывается исключение.
     *
     * @param  array                    $config массив значений конфигурации для валидации
     * @param  array                    $rules  правила валидации
     * @throws InvalidArgumentException если валидация не прошла
     * @throws Exception                если возникают другие ошибки
     */
    protected function validateConfiguration(array $config, array $rules): void
    {
        $validator = Validator::make($config, $rules, attributes: array_combine(array_keys($rules), array_keys($rules)));

        if ($validator->fails()) {
            $exceptionClass = $this->getConfigurationExceptionClass();
            throw new $exceptionClass($validator->errors()->all(), $config);
        }
    }
}
