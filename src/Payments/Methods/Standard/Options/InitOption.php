<?php

namespace DFiks\TBank\Payments\Methods\Standard\Options;

use DFiks\TBank\Payments\Options;
use DFiks\TBank\Payments\Receipts\Receipt;

class InitOption extends Options
{
    public function __construct(
        private readonly Receipt $receipt,
        private readonly ?string $orderId = null,
        private readonly ?string $description = null,
        private readonly ?string $language = 'ru',
    ) {
    }
}
