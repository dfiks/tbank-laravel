<?php

namespace DFiks\TBank\Payments\Request;

use DFiks\TBank\Configuration\General\GeneralConfiguration;
use DFiks\TBank\Configuration\Shop\Dto\ShopConfig;
use DFiks\TBank\Configuration\Shop\ShopConfiguration;
use DFiks\TBank\Payments\Contracts\ApiOptions;
use DFiks\TBank\Payments\Contracts\ApiResponse;
use DFiks\TBank\Payments\Enums\ApiMethods;
use DFiks\TBank\Payments\Response\ErrorResponse;
use DFiks\TBank\Payments\Traits\ApiRequestFake;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class ApiRequest
{
    use ApiRequestFake;

    private PendingRequest $http;

    public function __construct(
        private readonly ShopConfiguration $shopConfig,
        private readonly GeneralConfiguration $generalConfig,
    ) {
        $this->http = Http::withHeader('Content-Type', 'application/json')
            ->baseUrl(sprintf(
                '%s/%s',
                $this->generalConfig->get()->getEndpoint(),
                $this->generalConfig->get()->getApiVersion()
            ));
    }

    /**
     * @param ApiMethods      $method
     * @param string          $apiResponse
     * @param ApiOptions|null $options
     *
     * @throws ConnectionException
     * @return ApiResponse
     */
    public function request(ApiMethods $method, string $apiResponse, ?ApiOptions $options = null): ApiResponse
    {
        $fakeResponse = $this->getFakeResponse($method, $apiResponse);
        if ($fakeResponse !== null) {
            return $fakeResponse;
        }

        $request = $this->http->post($method->value, $options?->toArray());

        if ($request->status() === 403) {
            throw new ConnectionException();
        }

        $responseData = $request->json();

        if ($responseData['Success'] === false) {
            return new ErrorResponse($responseData);
        }

        return new $apiResponse($responseData);
    }

    public function getShopConfig(): ShopConfig
    {
        return $this->shopConfig->get();
    }
}
