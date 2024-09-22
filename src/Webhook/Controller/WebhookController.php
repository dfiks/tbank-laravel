<?php

namespace DFiks\TBank\Webhook\Controller;

use DFiks\TBank\Webhook\Handlers\DefaultWebhookHandler;
use DFiks\TBank\Webhook\Requests\WebhookRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;

class WebhookController extends Controller
{
    public function webhook(WebhookRequest $request): void
    {
        $handlerClass = Config::get('tbank.generals.webhook.handler', DefaultWebhookHandler::class);

        $handler = app($handlerClass);
        $handler->handle($request->all());
    }
}
