<?php

namespace DFiks\TBank\Webhook\Contracts;

interface WebhookHandlerInterface
{
    public function handle(array $webhookData): void;
}
