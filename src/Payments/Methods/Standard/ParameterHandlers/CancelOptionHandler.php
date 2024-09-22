<?php

namespace DFiks\TBank\Payments\Methods\Standard\ParameterHandlers;

use DFiks\TBank\Payments\Contracts\OptionHandlers;
use DFiks\TBank\Payments\Request\ApiRequest;

class CancelOptionHandler implements OptionHandlers
{
    private array $data;

    public function __construct(private readonly ApiRequest $request)
    {
    }

    public function run(): array
    {
        $terminal = $this->request->getShopConfig()->getTerminals();

        $data = [
            'TerminalKey' => $terminal->getTerminalId(),
            'PaymentId' => $this->data['paymentId'],
        ];

        $data['Token'] = $this->generateToken($data);

        return $data;
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
