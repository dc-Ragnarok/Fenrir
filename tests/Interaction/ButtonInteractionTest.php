<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Interaction;

use Exan\Fenrir\Interaction\ButtonInteraction;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Exan\Fenrir\Interaction\Helpers\InteractionCallbackBuilder;
use Exan\Fenrir\Websocket\Events\InteractionCreate;
use Fakes\Exan\Fenrir\DiscordFake;
use Fakes\Exan\Fenrir\PromiseFake;

class ButtonInteractionTest extends MockeryTestCase
{
    private function getInteractionCreate(): InteractionCreate
    {
        $interactionCreate = new InteractionCreate();
        $interactionCreate->id = '::interaction id::';
        $interactionCreate->token = '::interaction token::';
        $interactionCreate->application_id = '::application id::';

        return $interactionCreate;
    }

    public function testCreateInteractionResponse()
    {
        $discord = DiscordFake::get();
        $interactionCallbackBuilder = Mockery::mock(InteractionCallbackBuilder::class);

        $discord->rest->webhook
            ->shouldReceive('createInteractionResponse')
            ->with('::interaction id::', '::interaction token::', $interactionCallbackBuilder)
            ->andReturn(PromiseFake::get('::result::'))
            ->once();

        $buttonInteraction = new ButtonInteraction($this->getInteractionCreate(), $discord);

        $buttonInteraction->createInteractionResponse($interactionCallbackBuilder);
    }
}
