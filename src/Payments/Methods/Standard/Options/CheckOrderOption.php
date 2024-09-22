<?php

namespace DFiks\TBank\Payments\Methods\Standard\Options;

use DFiks\TBank\Payments\Options;

class CheckOrderOption extends Options
{
    public function __construct(
        private readonly string $orderId,
    ) {
    }
}
