<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir;

use Ragnarok\Fenrir\Command\FiredCommand;
use Ragnarok\Fenrir\CommandHandler;
use Ragnarok\Fenrir\Const\Events;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\EventHandler;
use Ragnarok\Fenrir\Gateway;
use Ragnarok\Fenrir\Parts\User;
use Ragnarok\Fenrir\Rest\GlobalCommand;
use Ragnarok\Fenrir\Rest\GuildCommand;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;
use Ragnarok\Fenrir\Rest\Rest;
use Ragnarok\Fenrir\Websocket\Events\Ready;
use Ragnarok\Fenrir\Websocket\Objects\Payload;
use JsonMapper;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use React\Promise\Promise;

class CommandHandlerTest extends MockeryTestCase
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

        $commandHandler = new CommandHandler($discord);

        $commandBuilder = CommandBuilder::new()
            ->setName('command')
            ->setDescription('::description::');

        $discord->rest->globalCommand
            ->shouldReceive('createApplicationCommand')
            ->with('::bot user id::', $commandBuilder)
            ->andReturn(new Promise(fn ($resolver) => $resolver))
            ->once();

        $commandHandler->registerGlobalCommand(
            $commandBuilder,
            fn (FiredCommand $command) => 1
        );

        $this->emitReady($discord->gateway->events);
    }

    public function testRegisterGuildCommand()
    {
        $discord = $this->getDiscord();

        $commandHandler = new CommandHandler($discord);

        $commandBuilder = CommandBuilder::new()
            ->setName('command')
            ->setDescription('::description::');

        $discord->rest->guildCommand
            ->shouldReceive('createApplicationCommand')
            ->with('::bot user id::', '::guild id::', $commandBuilder)
            ->andReturn(new Promise(fn ($resolver) => $resolver))
            ->once();

        $commandHandler->registerGuildCommand(
            $commandBuilder,
            '::guild id::',
            fn (FiredCommand $command) => 1
        );

        $this->emitReady($discord->gateway->events);
    }

    // public function testRegisterGuildCommand()
    // {
    //     $discord = $this->getDiscord();

    //     $commandHandler = new CommandHandler($discord);

    //     $commandBuilder = CommandBuilder::new()
    //         ->setName('command')
    //         ->setDescription('::description::');

    //     $discord->rest->guildCommand
    //         ->shouldReceive('createApplicationCommand')
    //         ->with('::bot user id::', $commandBuilder)
    //         ->andReturn(new Promise(fn ($resolver) => $resolver))
    //         ->once();

    //     $commandHandler->registerGuildCommand(
    //         $commandBuilder,
    //         '::guild id::',
    //         fn (FiredCommand $command) => 1
    //     );
    // }
}
