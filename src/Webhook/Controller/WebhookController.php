<?php

namespace DFiks\TBank\Webhook\Controller;

use DFiks\TBank\Webhook\Handlers\DefaultWebhookHandler;
use DFiks\TBank\Webhook\Requests\WebhookRequest;
use Illuminate\Routing\Controller;

class WebhookController extends Controller
{
    public function webhook(WebhookRequest $request): void
    {
        $handlerClass = config('tbank.webhook.handler', DefaultWebhookHandler::class);

        $handler = app($handlerClass);
        $handler->handle($request->all());
    }
}
