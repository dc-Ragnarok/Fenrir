<?php

declare(strict_types=1);

namespace Exan\Fenrir;

use Exan\Fenrir\Command\Helpers\InteractionCallbackBuilder;
use Exan\Fenrir\Enums\Command\InteractionCallbackTypes;
use Exan\Fenrir\Rest\Webhook;
use Tests\Exan\Fenrir\Rest\HttpHelperTestCase;

class WebhookTest extends HttpHelperTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->httpItem = new Webhook($this->http, $this->jsonMapper);
    }

    public function httpBindingsProvider(): array
    {
        return [
            'Create follow up message' => [
                'method' => 'createFollowUpMessage',
                'args' => [
                    '::application id::',
                    '::interaction token::',
                    InteractionCallbackBuilder::new()
                        ->setType(InteractionCallbackTypes::APPLICATION_COMMAND_AUTOCOMPLETE_RESULT),
                ],
                'mockOptions' => [
                    'method' => 'post',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
        ];
    }
}
