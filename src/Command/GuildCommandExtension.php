<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Command;

class GuildCommandExtension extends CommandExtension
{
    public function __construct(protected readonly string $guildId)
    {
    }
}
