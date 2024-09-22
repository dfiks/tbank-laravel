<?php

namespace DFiks\TBank\Payments\Methods\Standard\Options;

use DFiks\TBank\Payments\Options;

class CancelOption extends Options
{
    public function __construct(
        private readonly string $paymentId,
    ) {
    }
}
