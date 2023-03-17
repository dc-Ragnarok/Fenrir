<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir;

use Exan\Fenrir\Component\Button\DangerButton;
use Exan\Fenrir\Interaction\CommandInteraction;
use Exan\Fenrir\Const\Events;
use Exan\Fenrir\Discord;
use Exan\Fenrir\Enums\Parts\InteractionTypes;
use Exan\Fenrir\EventHandler;
use Exan\Fenrir\Gateway;
use Exan\Fenrir\Interaction\ButtonInteraction;
use Exan\Fenrir\InteractionHandler;
use Exan\Fenrir\Parts\User;
use Exan\Fenrir\Rest\GlobalCommand;
use Exan\Fenrir\Rest\GuildCommand;
use Exan\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Exan\Fenrir\Rest\Rest;
use Exan\Fenrir\Websocket\Events\Ready;
use Exan\Fenrir\Websocket\Objects\Payload;
use JsonMapper;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Exan\Fenrir\Parts\ApplicationCommand;
use Exan\Fenrir\Parts\InteractionData;
use Exan\Fenrir\Websocket\Events\InteractionCreate;
use React\Promise\Promise;

class InteractionHandlerTest extends MockeryTestCase
{
    private function getDiscord(): Discord
    {
        $discord = Mockery::mock(Discord::class);

        /** Set up required rest components */
        $discord->rest = Mockery::mock(Rest::class);
        $discord->rest->guildCommand = Mockery::mock(GuildCommand::class);
        $discord->rest->globalCommand = Mockery::mock(GlobalCommand::class);

        /** Set up required gateway components */
        $discord->gateway = Mockery::mock(Gateway::class);
        $discord->gateway->events = new EventHandler(new JsonMapper(), false);

        $ready = new Ready();
        $ready->user = new User();
        $ready->user->id = '::bot user id::';

        return $discord;
    }

    private function emitReady(EventHandler $eventHandler)
    {
        $payload = new Payload();

        $payload->op = 0;
        $payload->t = Events::READY;
        $payload->d = (object) [
            'user' => (object) ['id' => '::bot user id::']
        ];

        $eventHandler->handle(
            $payload
        );
    }

    public function testRegisterGlobalCommand()
    {
        $discord = $this->getDiscord();

        $interactionHandler = new InteractionHandler($discord);

        $commandBuilder = CommandBuilder::new()
            ->setName('command')
            ->setDescription('::description::');

        $discord->rest->globalCommand
            ->shouldReceive('createApplicationCommand')
            ->with('::bot user id::', $commandBuilder)
            ->andReturn(new Promise(fn ($resolver) => $resolver))
            ->once();

        $interactionHandler->registerGlobalCommand(
            $commandBuilder,
            fn (CommandInteraction $command) => 1
        );

        $this->emitReady($discord->gateway->events);
    }

    public function testRegisterGuildCommand()
    {
        $discord = $this->getDiscord();

        $interactionHandler = new InteractionHandler($discord);

        $commandBuilder = CommandBuilder::new()
            ->setName('command')
            ->setDescription('::description::');

        $discord->rest->guildCommand
            ->shouldReceive('createApplicationCommand')
            ->with('::bot user id::', '::guild id::', $commandBuilder)
            ->andReturn(new Promise(fn ($resolver) => $resolver))
            ->once();

        $interactionHandler->registerGuildCommand(
            $commandBuilder,
            '::guild id::',
            fn (CommandInteraction $command) => 1
        );

        $this->emitReady($discord->gateway->events);
    }

    public function testItOnlySetsASingleListener()
    {
        $discord = $this->getDiscord();

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

    public function testRegisterCommandIsGlobalWithoutDevGuild()
    {
        $discord = $this->getDiscord();

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

    public function testRegisterCommandIsGuildWithDevGuild()
    {
        $discord = $this->getDiscord();

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

    public function testItHandlesAnInteraction()
    {
        $discord = $this->getDiscord();

        $interactionHandler = new InteractionHandler($discord);

        $commandBuilder = CommandBuilder::new()
            ->setName('command')
            ->setDescription('::description::');

        $discord->rest->globalCommand
            ->shouldReceive('createApplicationCommand')
            ->with('::bot user id::', $commandBuilder)
            ->andReturn(new Promise(function ($resolver) {
                $applicationCommand = new ApplicationCommand();
                $applicationCommand->id = '::application command id::';

                $resolver($applicationCommand);
            }))
            ->once();

        $hasRun = false;

        $interactionHandler->registerGlobalCommand(
            $commandBuilder,
            function ($command) use (&$hasRun) {
                $hasRun = true;

                $this->assertInstanceOf(CommandInteraction::class, $command);
            }
        );

        $this->emitReady($discord->gateway->events);

        $interactionCreate = new InteractionCreate();
        $interactionCreate->type = InteractionTypes::APPLICATION_COMMAND;
        $interactionCreate->data = new InteractionData();
        $interactionCreate->data->id = '::application command id::';

        $discord->gateway->events->emit(Events::INTERACTION_CREATE, [$interactionCreate]);

        $this->assertTrue($hasRun, 'Command handler has not been run');
    }

    public function testItIgnoresCommandIfNoHanlderIsRegistered()
    {
        $discord = $this->getDiscord();

        $interactionHandler = new InteractionHandler($discord);

        $commandBuilder = CommandBuilder::new()
            ->setName('command')
            ->setDescription('::description::');

        $discord->rest->globalCommand
            ->shouldReceive('createApplicationCommand')
            ->with('::bot user id::', $commandBuilder)
            ->andReturn(new Promise(function ($resolver) {
                $applicationCommand = new ApplicationCommand();
                $applicationCommand->id = '::application command id::';

                $resolver($applicationCommand);
            }))
            ->once();

        $hasRun = false;

        $interactionHandler->registerGlobalCommand(
            $commandBuilder,
            function ($command) use (&$hasRun) {
                $hasRun = true;
            }
        );

        $this->emitReady($discord->gateway->events);

        $interactionCreate = new InteractionCreate();
        $interactionCreate->type = InteractionTypes::APPLICATION_COMMAND;
        $interactionCreate->data = new InteractionData();
        $interactionCreate->data->id = '::other application command id::';

        $discord->gateway->events->emit(Events::INTERACTION_CREATE, [$interactionCreate]);

        $this->assertFalse($hasRun, 'Command handler should not have been run');
    }

    public function testItCanRegisterButtonInteractionHandlers()
    {
        $discord = $this->getDiscord();
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

        $interactionCreate = (new JsonMapper())->map(
            json_decode(json_encode([ // Json mapper requires object instead of array
                'id' => '::interaction id::',
                'token' => '::token::',
                'type' => InteractionTypes::MESSAGE_COMPONENT->value,
                'application_id' => '::application id::',
                'data' => [
                    'component_type' => 2, // @todo enum
                    'custom_id' => '::custom id::',
                ],
            ])),
            new InteractionCreate()
        );

        $discord->gateway->events->emit(Events::INTERACTION_CREATE, [$interactionCreate]);

        $this->assertTrue($hasRun, 'Handler did not run');
    }

    public function testItOnlyRegistersASingleListener()
    {
        $discord = $this->getDiscord();
        $interactionHandler = new InteractionHandler($discord);

        $button = new DangerButton('::custom id::');
        $interactionHandler->onButtonInteraction($button, fn (ButtonInteraction $btnInt) => null);

        $otherButton = new DangerButton('::some other custom id::');
        $interactionHandler->onButtonInteraction($otherButton, fn (ButtonInteraction $btnInt) => null);

        $this->assertCount(1, $discord->gateway->events->listeners(Events::INTERACTION_CREATE));
    }

    public function testItRemovesButtonListenerIfHandlerReturnsTrue()
    {
        $discord = $this->getDiscord();
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

        $interactionCreate = (new JsonMapper())->map(
            json_decode(json_encode([ // Json mapper requires object instead of array
                'id' => '::interaction id::',
                'token' => '::token::',
                'type' => InteractionTypes::MESSAGE_COMPONENT->value,
                'application_id' => '::application id::',
                'data' => [
                    'component_type' => 2, // @todo enum
                    'custom_id' => '::custom id::',
                ],
            ])),
            new InteractionCreate()
        );

        $discord->gateway->events->emit(Events::INTERACTION_CREATE, [$interactionCreate]);

        $this->assertEquals(1, $runs, 'Handler did not run');

        $discord->gateway->events->emit(Events::INTERACTION_CREATE, [$interactionCreate]);

        $this->assertEquals(1, $runs, 'Handler ran incorrect number of times');
    }
}
