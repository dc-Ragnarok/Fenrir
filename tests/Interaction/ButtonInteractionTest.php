<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Interaction;

use Ragnarok\Fenrir\Interaction\ButtonInteraction;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Ragnarok\Fenrir\Interaction\Helpers\InteractionCallbackBuilder;
use Ragnarok\Fenrir\Websocket\Events\InteractionCreate;
use Fakes\Ragnarok\Fenrir\DiscordFake;
use Fakes\Ragnarok\Fenrir\PromiseFake;

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

    public function testCreateInteractionResponse(): void
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
