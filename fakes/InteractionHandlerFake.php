<?php

declare(strict_types=1);

namespace Fakes\Ragnarok\Fenrir;

use Ragnarok\Fenrir\InteractionHandler;
use Ragnarok\Fenrir\Rest\Helpers\Command\CommandBuilder;
use PHPUnit\Framework\Assert;

class InteractionHandlerFake extends InteractionHandler
{
    public array $dynamicCommands = [];
    public array $guildCommands = [];
    public array $globalCommands = [];

    public function __construct()
    {
    }

    public static function get(): InteractionHandler
    {
        return new static();
    }

    public function registerCommand(CommandBuilder $commandBuilder, callable $handler): void
    {
        $this->dynamicCommands[] = ['builder' => $commandBuilder, 'handler' => $handler];
    }

    public function registerGuildCommand(CommandBuilder $commandBuilder, string $guildId, callable $handler): void
    {
        $this->guildCommands[] = ['builder' => $commandBuilder, 'handler' => $handler];
    }

    public function registerGlobalCommand(CommandBuilder $commandBuilder, callable $handler): void
    {
        $this->globalCommands[] = ['builder' => $commandBuilder, 'handler' => $handler];
    }

    /**
     * @return CommandBuilder[]
     */
    private function getCommandBuilders(array $commands): array
    {
        return array_map(
            static fn (array $command) => $command['builder'],
            $commands
        );
    }

    public function assertHasDynamicCommand(callable $validator): void
    {
        Assert::assertNotEmpty(
            array_filter($this->getCommandBuilders($this->dynamicCommands), $validator),
            'No commands found with provided filter'
        );
    }

    public function assertHasGuildCommand(callable $validator): void
    {
        Assert::assertNotEmpty(
            array_filter($this->getCommandBuilders($this->guildCommands), $validator),
            'No commands found with provided filter'
        );
    }

    public function assertHasGlobalCommand(callable $validator): void
    {
        Assert::assertNotEmpty(
            array_filter($this->getCommandBuilders($this->globalCommands), $validator),
            'No commands found with provided filter'
        );
    }
}
