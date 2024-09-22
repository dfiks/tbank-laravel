<?php

namespace DFiks\TBank\Payments\Methods\Standard;

use DFiks\TBank\Payments\Contracts\ApiResponse;
use DFiks\TBank\Payments\Enums\ApiMethods;
use DFiks\TBank\Payments\Methods\Standard\Options\CancelOption;
use DFiks\TBank\Payments\Methods\Standard\Options\CheckOrderOption;
use DFiks\TBank\Payments\Methods\Standard\Options\GetStateOption;
use DFiks\TBank\Payments\Methods\Standard\Options\InitOption;
use DFiks\TBank\Payments\Methods\Standard\ParameterHandlers\CancelOptionHandler;
use DFiks\TBank\Payments\Methods\Standard\ParameterHandlers\CheckOrderOptionHandler;
use DFiks\TBank\Payments\Methods\Standard\ParameterHandlers\GetStateOptionHandler;
use DFiks\TBank\Payments\Methods\Standard\ParameterHandlers\InitOptionHandler;
use DFiks\TBank\Payments\Payment;
use DFiks\TBank\Payments\Response\CancelResponse;
use DFiks\TBank\Payments\Response\CheckOrderResponse;
use DFiks\TBank\Payments\Response\ErrorResponse;
use DFiks\TBank\Payments\Response\GetStateResponse;
use DFiks\TBank\Payments\Response\InitResponse;
use Illuminate\Http\Client\ConnectionException;

class StandardPayments extends Payment
{
    /**
     * Инициализировать платеж.
     *
     * Метод инициализирует платежную сессию.
     *
     * @param  InitOption                             $option
     * @throws ConnectionException
     * @return InitResponse|ErrorResponse|ApiResponse
     */
    public function init(InitOption $option): InitResponse|ErrorResponse|ApiResponse
    {
        return $this->api->request(
            method: ApiMethods::Init,
            apiResponse: InitResponse::class,
            options: $option->attachHandler(app(InitOptionHandler::class)),
        );
    }

    /**
     * Получить статуса платежа.
     *
     * Метод возвращает статус платежа.
     *
     * @param  GetStateOption                             $option
     * @throws ConnectionException
     * @return GetStateResponse|ErrorResponse|ApiResponse
     */
    public function getState(GetStateOption $option): GetStateResponse|ErrorResponse|ApiResponse
    {
        return $this->api->request(
            method: ApiMethods::GetState,
            apiResponse: GetStateResponse::class,
            options: $option->attachHandler(app(GetStateOptionHandler::class)),
        );
    }

    /**
     * Получить статус заказа.
     *
     * Метод возвращает статус заказа.
     *
     * @param  CheckOrderOption                             $option
     * @throws ConnectionException
     * @return CheckOrderResponse|ErrorResponse|ApiResponse
     */
    public function checkOrder(CheckOrderOption $option): CheckOrderResponse|ErrorResponse|ApiResponse
    {
        return $this->api->request(
            method: ApiMethods::CheckOrder,
            apiResponse: CheckOrderResponse::class,
            options: $option->attachHandler(app(CheckOrderOptionHandler::class)),
        );
    }

    /**
     * Отменить платеж.
     *
     * Отменяет платежную сессию. В зависимости от статуса платежа, переводит его в следующие состояния:
     *
     * @param  CancelOption                             $option
     * @throws ConnectionException
     * @return CancelResponse|ErrorResponse|ApiResponse
     */
    public function cancel(CancelOption $option): CancelResponse|ErrorResponse|ApiResponse
    {
        return $this->api->request(
            method: ApiMethods::Cancel,
            apiResponse: CancelResponse::class,
            options: $option->attachHandler(app(CancelOptionHandler::class)),
        );
    }
}
