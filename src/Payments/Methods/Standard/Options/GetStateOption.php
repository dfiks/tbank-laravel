<?php

namespace DFiks\TBank\Payments\Methods\Standard\Options;

use DFiks\TBank\Payments\Options;

class GetStateOption extends Options
{
    public function __construct(
        private string $paymentId,
        private ?string $ip = null,
    ) {
    }
}
