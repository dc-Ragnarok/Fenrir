<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Command;

use Fakes\Ragnarok\Fenrir\DiscordFake;
use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Discord;

class CommandExtensionTest extends TestCase
{
    private Discord $discord;

    protected function setUp(): void
    {
        $this->discord = DiscordFake::get();
    }
}
