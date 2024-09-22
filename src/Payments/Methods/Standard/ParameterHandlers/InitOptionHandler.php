<?php

namespace DFiks\TBank\Payments\Methods\Standard\ParameterHandlers;

use DFiks\TBank\Payments\Contracts\OptionHandlers;
use DFiks\TBank\Payments\Enums\TaxationType;
use DFiks\TBank\Payments\Receipts\Receipt;
use DFiks\TBank\Payments\Request\ApiRequest;
use Illuminate\Support\Str;

class InitOptionHandler implements OptionHandlers
{
    private array $data;

    public function __construct(private readonly ApiRequest $request)
    {
    }

    public function run(): array
    {
        $terminal = $this->request->getShopConfig()->getTerminals();

        $forToken = [
            'TerminalKey' => $terminal->getTerminalId(),
            'OrderId' => $this->data['orderId'] ?? Str::orderedUuid()->toString(),
        ];

        if (isset($this->data['description']) && $this->data['description'] !== null) {
            $forToken['Description'] = $this->data['description'];
        }

        if (isset($this->data['language']) && $this->data['language'] !== null) {
            $forToken['Language'] = $this->data['language'];
        }

        if ($successUrl = $terminal->getSuccessUrl()) {
            $forToken['SuccessURL'] = $successUrl;
        }

        if ($errorUrl = $terminal->getErrorUrl()) {
            $forToken['ErrorURL'] = $errorUrl;
        }

        if ($notificationUrl = $terminal->getHttpNotification()) {
            $forToken['NotificationURL'] = $notificationUrl;
        }

        /** @var Receipt $receipt */
        $receipt = $this->data['receipt'];
        $receipt->setTaxation(TaxationType::from($terminal->getTaxation()));

        $forToken['Amount'] = $receipt->getTotalAmount();

        $forToken['Token'] = $this->generateToken($forToken);

        return array_merge($forToken, $receipt->toArray());
    }

    public function attachData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    private function generateToken(array $args): string
    {
        $token = '';
        $args['Password'] = $this->request->getShopConfig()->getTerminals()->getPassword();
        ksort($args);
        foreach ($args as $key => $arg) {
            if (!is_array($arg)) {
                if (is_bool($arg)) {
                    $token .= $arg ? 'true' : 'false';
                } else {
                    $token .= $arg;
                }
            }
        }

        return hash('sha256', $token);
    }
}
