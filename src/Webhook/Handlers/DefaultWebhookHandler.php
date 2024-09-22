<?php

namespace DFiks\TBank\Webhook\Handlers;

use DFiks\TBank\Webhook\Contracts\WebhookHandlerInterface;

class DefaultWebhookHandler implements WebhookHandlerInterface
{
    public function handle(array $webhookData): void
    {
    }
}
