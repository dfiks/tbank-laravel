<?php

namespace DFiks\TBank\Payments\Traits;

use DFiks\TBank\Payments\Enums\ApiMethods;
use DFiks\TBank\Payments\Contracts\ApiResponse;
use InvalidArgumentException;

trait ApiRequestFake
{
    private static bool $isFake = false;
    private static array $fakeResponses = [];

    /**
     * Включить режим подделки ответов с возможностью передать фейковые данные.
     *
     * @param  array $fakeResponses
     * @return void
     */
    public static function fake(array $fakeResponses = []): void
    {
        self::$isFake = true;

        foreach ($fakeResponses as $method => $response) {
            static::setFakeResponse($method, $response);
        }
    }

    /**
     * Выключить режим подделки ответов.
     *
     * @return void
     */
    public static function real(): void
    {
        self::$isFake = false;
        self::$fakeResponses = [];
    }

    /**
     * Добавить фейковый ответ для метода.
     *
     * @param  ApiMethods|string $method
     * @param  array|ApiResponse $response
     * @return void
     */
    public static function setFakeResponse(ApiMethods|string $method, array|ApiResponse $response): void
    {
        if (is_string($method)) {
            $method = ApiMethods::tryFrom($method);
            if ($method === null) {
                throw new InvalidArgumentException("Недопустимое значение метода: $method");
            }
        }

        if (is_array($response)) {
            self::$fakeResponses[$method->value] = $response;
        } elseif ($response instanceof ApiResponse) {
            self::$fakeResponses[$method->value] = $response->toArray();
        } else {
            throw new InvalidArgumentException('Ответ должен быть массивом или экземпляром ApiResponse.');
        }
    }

    /**
     * Проверить, используется ли фейковый режим, и вернуть фейковый ответ, если он задан.
     *
     * @param  ApiMethods   $method
     * @param  string       $apiResponse
     * @return ?ApiResponse
     */
    private function getFakeResponse(ApiMethods $method, string $apiResponse): ?ApiResponse
    {
        if (self::$isFake && isset(self::$fakeResponses[$method->value])) {
            $fakeResponse = self::$fakeResponses[$method->value];

            return new $apiResponse($fakeResponse);
        }

        return null;
    }
}
