<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Command;

use Fakes\Ragnarok\Fenrir\DiscordFake;
use Fakes\Ragnarok\Fenrir\PromiseFake;
use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Command\GuildCommandExtension;
use Ragnarok\Fenrir\Constants\Events;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Enums\ApplicationCommandOptionType;
use Ragnarok\Fenrir\Enums\InteractionType;
use Ragnarok\Fenrir\Gateway\Events\InteractionCreate;
use Ragnarok\Fenrir\Interaction\CommandInteraction;
use Ragnarok\Fenrir\Parts\ApplicationCommand;
use Ragnarok\Fenrir\Parts\ApplicationCommandOptionStructure;
use Ragnarok\Fenrir\Parts\InteractionData;

class GuildCommandExtensionTest extends TestCase
{
    private Discord $discord;

    protected function setUp(): void
    {
        $this->discord = DiscordFake::get();
    }

    public function testItEmitsEventsForApplicationCommands()
    {
        $commands = [new ApplicationCommand(), new ApplicationCommand()];

        $commands[0]->id = '::application command 1::';
        $commands[0]->name = 'command-1';

        $commands[1]->id = '::application command 2::';
        $commands[1]->name = 'command-2';

        $this->discord->rest->guildCommand->shouldReceive()
            ->getCommands('::guild id::', '::application id::')
            ->andReturns(PromiseFake::get($commands));

        $extension = new GuildCommandExtension('::application id::', '::guild id::');
        $extension->initialize($this->discord);

        $hasRun = [false, false];

        $extension->on('command-1', function (CommandInteraction $firedCommand) use (&$hasRun) {
            $hasRun[0] = true;
        });

        $extension->on('command-2', function (CommandInteraction $firedCommand) use (&$hasRun) {
            $hasRun[1] = true;
        });

        $interaction = new InteractionCreate();
        $interaction->type = InteractionType::APPLICATION_COMMAND;
        $interaction->data = new InteractionData();
        $interaction->data->id = '::application command 1::';

        $this->discord->gateway->events->emit(
            Events::INTERACTION_CREATE,
            [$interaction]
        );

        $interaction->data->id = '::application command 2::';

        $this->discord->gateway->events->emit(
            Events::INTERACTION_CREATE,
            [$interaction]
        );

        $this->assertTrue($hasRun[0], 'Command 1 did not run');
        $this->assertTrue($hasRun[1], 'Command 2 did not run');
    }

    public function testItDoesNotEmitCommandIfDifferentInteractionOccured()
    {
        $command = new ApplicationCommand();

        $command->id = '::application command::';
        $command->name = 'command';

        $this->discord->rest->guildCommand->shouldReceive()
            ->getCommands('::guild id::', '::application id::')
            ->andReturns(PromiseFake::get([$command]));

        $extension = new GuildCommandExtension('::application id::', '::guild id::');
        $extension->initialize($this->discord);

        $hasRun = false;

        $extension->on('command', function (CommandInteraction $firedCommand) use (&$hasRun) {
            $hasRun = true;
        });

        $interaction = new InteractionCreate();
        $interaction->type = InteractionType::PING;
        $interaction->data = new InteractionData();
        $interaction->data->id = '::application command::';

        $this->discord->gateway->events->emit(
            Events::INTERACTION_CREATE,
            [$interaction]
        );

        $this->assertFalse($hasRun, 'Command was emitted wrongfully');
    }

    /**
     * @dataProvider nameMappingProvider
     * @depends testItEmitsEventsForApplicationCommands
     */
    public function testItMapsNamesCorrectly(ApplicationCommand $command, string $expectedName)
    {
        $command->id = '::application command::';

        $this->discord->rest->guildCommand->shouldReceive()
            ->getCommands('::guild id::', '::application id::')
            ->andReturns(PromiseFake::get([$command]));

        $extension = new GuildCommandExtension('::application id::', '::guild id::');
        $extension->initialize($this->discord);

        $hasRun = false;

        $extension->on($expectedName, function (CommandInteraction $firedCommand) use (&$hasRun) {
            $hasRun = true;
        });

        $interaction = new InteractionCreate();
        $interaction->type = InteractionType::APPLICATION_COMMAND;
        $interaction->data = new InteractionData();
        $interaction->data->id = '::application command::';

        $this->discord->gateway->events->emit(
            Events::INTERACTION_CREATE,
            [$interaction]
        );

        $this->assertTrue($hasRun, 'Command was emitted wrongfully');
    }

    public static function nameMappingProvider(): array
    {
        return [
            'Plain name' => [
                'command' => (function () {
                    $command = new ApplicationCommand();
                    $command->name = 'command-name';

                    return $command;
                })(),
                'expectedName' => 'command-name'
            ],

            'Nested 1 layer' => [
                'command' => (function () {
                    $command = new ApplicationCommand();
                    $command->name = 'command-name';

                    $command->options = [new ApplicationCommandOptionStructure()];
                    $command->options[0]->name = 'sub';
                    $command->options[0]->type = ApplicationCommandOptionType::SUB_COMMAND;

                    return $command;
                })(),
                'expectedName' => 'command-name.sub'
            ],

            'Nested 2 layer' => [
                'command' => (function () {
                    $command = new ApplicationCommand();
                    $command->name = 'command-name';

                    $command->options = [new ApplicationCommandOptionStructure()];
                    $command->options[0]->name = 'double';
                    $command->options[0]->type = ApplicationCommandOptionType::SUB_COMMAND_GROUP;

                    $command->options[0]->options = [new ApplicationCommandOptionStructure()];
                    $command->options[0]->options[0]->name = 'sub';
                    $command->options[0]->options[0]->type = ApplicationCommandOptionType::SUB_COMMAND_GROUP;

                    return $command;
                })(),
                'expectedName' => 'command-name.double.sub'
            ],

            'Nested 3 layer' => [ // NOTE: Not supported by Discord
                'command' => (function () {
                    $command = new ApplicationCommand();
                    $command->name = 'command-name';

                    $command->options = [new ApplicationCommandOptionStructure()];
                    $command->options[0]->name = 'double';
                    $command->options[0]->type = ApplicationCommandOptionType::SUB_COMMAND_GROUP;

                    $command->options[0]->options = [new ApplicationCommandOptionStructure()];
                    $command->options[0]->options[0]->name = 'sub';
                    $command->options[0]->options[0]->type = ApplicationCommandOptionType::SUB_COMMAND_GROUP;

                    $command->options[0]->options[0]->options = [new ApplicationCommandOptionStructure()];
                    $command->options[0]->options[0]->options[0]->name = 'dub';
                    $command->options[0]->options[0]->options[0]->type = ApplicationCommandOptionType::SUB_COMMAND_GROUP;

                    return $command;
                })(),
                'expectedName' => 'command-name.double.sub.dub'
            ],
        ];
    }
}
