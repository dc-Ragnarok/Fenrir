<?php

declare(strict_types=1);

namespace Exan\Fenrir;

use Exan\Fenrir\Interaction\Helpers\InteractionCallbackBuilder;
use Exan\Fenrir\Enums\Command\InteractionCallbackTypes;
use Exan\Fenrir\Parts\Message;
use Exan\Fenrir\Rest\Helpers\Webhook\EditWebhookBuilder;
use Exan\Fenrir\Rest\Webhook;
use Tests\Exan\Fenrir\Rest\HttpHelperTestCase;

class WebhookTest extends HttpHelperTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->httpItem = new Webhook($this->http, $this->dataMapper);
    }

    public function httpBindingsProvider(): array
    {
        return [
            'Create interaction response' => [
                'method' => 'createInteractionResponse',
                'args' => [
                    '::interaction id::',
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
            'Get original interaction response' => [
                'method' => 'getOriginalInteractionResponse',
                'args' => [
                    '::application id::',
                    '::interaction token::',
                ],
                'mockOptions' => [
                    'method' => 'get',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => Message::class,
                ],
            ],
            'Edit original interaction response' => [
                'method' => 'editOriginalInteractionResponse',
                'args' => [
                    '::application id::',
                    '::interaction token::',
                    EditWebhookBuilder::new()
                ],
                'mockOptions' => [
                    'method' => 'patch',
                    'return' => (object) [],
                ],
                'validationOptions' => [
                    'returnType' => Message::class,
                ],
            ],
            'Delete original interaction response' => [
                'method' => 'deleteOriginalInteractionResponse',
                'args' => [
                    '::application id::',
                    '::interaction token::'
                ],
                'mockOptions' => [
                    'method' => 'delete',
                    'return' => null,
                ],
                'validationOptions' => [],
            ],
        ];
    }
}
