<?php

namespace DFiks\TBank\Payments;

use DFiks\TBank\Payments\Contracts\Payments;
use DFiks\TBank\Payments\Request\ApiRequest;

class Payment implements Payments
{
    public function __construct(protected ApiRequest $api)
    {
    }
}
