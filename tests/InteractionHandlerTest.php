<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir;

use Ragnarok\Fenrir\Component\Button\DangerButton;
use Ragnarok\Fenrir\Interaction\CommandInteraction;
use Ragnarok\Fenrir\Constants\Events;
use Fakes\Ragnarok\Fenrir\DataMapperFake;
use Ragnarok\Fenrir\Enums\Parts\InteractionTypes;
use Ragnarok\Fenrir\EventHandler;
use Ragnarok\Fenrir\Interaction\ButtonInteraction;
use Ragnarok\Fenrir\InteractionHandler;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Ragnarok\Fenrir\Websocket\Objects\Payload;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Websocket\Events\InteractionCreate;
use Fakes\Ragnarok\Fenrir\DiscordFake;
use Fakes\Ragnarok\Fenrir\PromiseFake;
use React\Promise\Promise;

class InteractionHandlerTest extends MockeryTestCase
{
    private function emitReady(EventHandler $eventHandler): void
    {
        /** @var Payload */
        $payload = DataMapperFake::get()->map([
            'op' => 0,
            't' => Events::READY,
            'd' => [
                'user' => [
                    'id' => '::bot user id::',
                ],
            ],
        ], Payload::class);

        $eventHandler->handle(
            $payload
        );
    }

    public function testRegisterGlobalCommand(): void
    {
        $discord = DiscordFake::get();

        $interactionHandler = new InteractionHandler($discord);

        $commandBuilder = CommandBuilder::new()
            ->setName('command')
            ->setDescription('::description::');

        $discord->rest->globalCommand
            ->shouldReceive('createApplicationCommand')
            ->with('::bot user id::', $commandBuilder)
            ->andReturn(PromiseFake::get())
            ->once();

        $interactionHandler->registerGlobalCommand(
            $commandBuilder,
            fn (CommandInteraction $command) => 1
        );

        $this->emitReady($discord->gateway->events);
    }

    public function testRegisterGuildCommand(): void
    {
        $discord = DiscordFake::get();

        $interactionHandler = new InteractionHandler($discord);

        $commandBuilder = CommandBuilder::new()
            ->setName('command')
            ->setDescription('::description::');

        $discord->rest->guildCommand
            ->shouldReceive('createApplicationCommand')
            ->with('::bot user id::', '::guild id::', $commandBuilder)
            ->andReturn(PromiseFake::get())
            ->once();

        $interactionHandler->registerGuildCommand(
            $commandBuilder,
            '::guild id::',
            fn (CommandInteraction $command) => 1
        );

        $this->emitReady($discord->gateway->events);
    }

    public function testItOnlySetsASingleListener(): void
    {
        $discord = DiscordFake::get();

        $interactionHandler = new InteractionHandler($discord);

        $commandBuilder = CommandBuilder::new()
            ->setName('command')
            ->setDescription('::description::');

        $interactionHandler->registerGuildCommand(
            $commandBuilder,
            '::guild id::',
            fn (CommandInteraction $command) => 1
        );

        $interactionHandler->registerGuildCommand(
            $commandBuilder,
            '::guild id::',
            fn (CommandInteraction $command) => 1
        );

        $this->assertCount(1, $discord->gateway->events->listeners(Events::INTERACTION_CREATE));
    }

    public function testRegisterCommandIsGlobalWithoutDevGuild(): void
    {
        $discord = DiscordFake::get();

        $interactionHandler = new InteractionHandler($discord);

        $commandBuilder = CommandBuilder::new()
            ->setName('command')
            ->setDescription('::description::');

        $discord->rest->globalCommand
            ->shouldReceive('createApplicationCommand')
            ->with('::bot user id::', $commandBuilder)
            ->andReturn(new Promise(fn ($resolver) => $resolver))
            ->once();

        $interactionHandler->registerCommand(
            $commandBuilder,
            fn (CommandInteraction $command) => 1
        );

        $this->emitReady($discord->gateway->events);
    }

    public function testRegisterCommandIsGuildWithDevGuild(): void
    {
        $discord = DiscordFake::get();

        $interactionHandler = new InteractionHandler($discord, '::guild id::');

        $commandBuilder = CommandBuilder::new()
            ->setName('command')
            ->setDescription('::description::');

        $interactionHandler->registerCommand(
            $commandBuilder,
            fn (CommandInteraction $command) => 1
        );

        $interactionHandler->registerGuildCommand(
            $commandBuilder,
            '::guild id::',
            fn (CommandInteraction $command) => 1
        );

        $this->assertCount(1, $discord->gateway->events->listeners(Events::INTERACTION_CREATE));
    }

    public function testItHandlesAnInteraction(): void
    {
        $discord = DiscordFake::get();

        $interactionHandler = new InteractionHandler($discord);

        $commandBuilder = CommandBuilder::new()
            ->setName('command')
            ->setDescription('::description::');

        $discord->rest->globalCommand
            ->shouldReceive('createApplicationCommand')
            ->with('::bot user id::', $commandBuilder)
            ->andReturn(PromiseFake::get(
                DataMapperFake::get()->map([
                    'id' => '::application command id::',
                ], ApplicationCommand::class)
            ))
            ->once();

        $discord->rest->guildCommand
            ->shouldReceive('createApplicationCommand')
            ->with('::bot user id::', '::guild id::', $commandBuilder)
            ->andReturn(PromiseFake::get(
                DataMapperFake::get()->map([
                    'id' => '::guild application command id::',
                ], ApplicationCommand::class)
            ))
            ->once();

        $hasRun = false;

        $interactionHandler->registerGlobalCommand(
            $commandBuilder,
            function ($command) use (&$hasRun) {
                $hasRun = true;

                $this->assertInstanceOf(CommandInteraction::class, $command);
            }
        );

        $interactionHandler->registerGuildCommand(
            $commandBuilder,
            '::guild id::',
            function ($command) use (&$hasRun) {
                $hasRun = true;

                $this->assertInstanceOf(CommandInteraction::class, $command);
            }
        );

        $this->emitReady($discord->gateway->events);

        /** @var InteractionCreate */
        $interactionCreate = DataMapperFake::get()->map([
            'type' => InteractionTypes::APPLICATION_COMMAND->value,
            'data' => [
                'id' => '::application command id::',
            ],
        ], InteractionCreate::class);

        $discord->gateway->events->emit(Events::INTERACTION_CREATE, [$interactionCreate]);

        $this->assertTrue($hasRun, 'Command handler has not been run');
    }

    public function testItIgnoresCommandIfNoHanlderIsRegistered(): void
    {
        $discord = DiscordFake::get();

        $interactionHandler = new InteractionHandler($discord);

        $commandBuilder = CommandBuilder::new()
            ->setName('command')
            ->setDescription('::description::');

        $discord->rest->globalCommand
            ->shouldReceive('createApplicationCommand')
            ->with('::bot user id::', $commandBuilder)
            ->andReturn(PromiseFake::get(
                DataMapperFake::get()->map([
                    'id' => '::application command id::',
                ], ApplicationCommand::class)
            ))
            ->once();

        $hasRun = false;

        $interactionHandler->registerGlobalCommand(
            $commandBuilder,
            function ($command) use (&$hasRun) {
                $hasRun = true;
            }
        );

        $this->emitReady($discord->gateway->events);

        /** @var InteractionCreate */
        $interactionCreate = DataMapperFake::get()->map([
            'type' => InteractionTypes::APPLICATION_COMMAND->value,
            'data' => [
                'id' => '::other application command id::',
            ],
        ], InteractionCreate::class);

        $discord->gateway->events->emit(Events::INTERACTION_CREATE, [$interactionCreate]);

        $this->assertFalse($hasRun, 'Command handler should not have been run');
    }

    public function testItCanRegisterButtonInteractionHandlers(): void
    {
        $discord = DiscordFake::get();
        $interactionHandler = new InteractionHandler($discord);

        $button = new DangerButton('::custom id::');

        $hasRun = false;
        $interactionHandler->onButtonInteraction(
            $button,
            function (ButtonInteraction $buttonInteraction) use (&$hasRun) {
                $hasRun = true;
            }
        );

        $this->assertCount(1, $discord->gateway->events->listeners(Events::INTERACTION_CREATE));

        $interactionCreate = DataMapperFake::get()->map([
                'id' => '::interaction id::',
                'token' => '::token::',
                'type' => InteractionTypes::MESSAGE_COMPONENT->value,
                'application_id' => '::application id::',
                'data' => [
                    'component_type' => 2, // @todo enum
                    'custom_id' => '::custom id::',
                ],
            ], InteractionCreate::class);

        $discord->gateway->events->emit(Events::INTERACTION_CREATE, [$interactionCreate]);

        $this->assertTrue($hasRun, 'Handler did not run');
    }

    public function testItOnlyRegistersASingleListener(): void
    {
        $discord = DiscordFake::get();
        $interactionHandler = new InteractionHandler($discord);

        $button = new DangerButton('::custom id::');
        $interactionHandler->onButtonInteraction($button, fn (ButtonInteraction $btnInt) => null);

        $otherButton = new DangerButton('::some other custom id::');
        $interactionHandler->onButtonInteraction($otherButton, fn (ButtonInteraction $btnInt) => null);

        $this->assertCount(1, $discord->gateway->events->listeners(Events::INTERACTION_CREATE));
    }

    public function testItRemovesButtonListenerIfHandlerReturnsTrue(): void
    {
        $discord = DiscordFake::get();
        $interactionHandler = new InteractionHandler($discord);

        $button = new DangerButton('::custom id::');

        $runs = 0;
        $interactionHandler->onButtonInteraction(
            $button,
            function (ButtonInteraction $buttonInteraction) use (&$runs) {
                $runs++;

                return true;
            }
        );

        $this->assertCount(1, $discord->gateway->events->listeners(Events::INTERACTION_CREATE));

        $interactionCreate = DataMapperFake::get()->map([
                'id' => '::interaction id::',
                'token' => '::token::',
                'type' => InteractionTypes::MESSAGE_COMPONENT->value,
                'application_id' => '::application id::',
                'data' => [
                    'component_type' => 2, // @todo enum
                    'custom_id' => '::custom id::',
                ],
            ], InteractionCreate::class);

        $discord->gateway->events->emit(Events::INTERACTION_CREATE, [$interactionCreate]);

        $this->assertEquals(1, $runs, 'Handler did not run');

        $discord->gateway->events->emit(Events::INTERACTION_CREATE, [$interactionCreate]);

        $this->assertEquals(1, $runs, 'Handler ran incorrect number of times');
    }
}
