<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir;

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\CommandHandler;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Gateway;
use Ragnarok\Fenrir\Rest\Rest;
use PHPUnit\Framework\TestCase;

class DiscordTest extends TestCase
{
    public function testItInitializesGateway()
    {
        $discord = new Discord('::token::', new Bitwise());

        $discord->withGateway();

        $this->assertInstanceOf(Gateway::class, $discord->gateway);
    }

    public function testItInitializesRest()
    {
        $discord = new Discord('::token::', new Bitwise());

        $discord->withRest();

        $this->assertInstanceOf(Rest::class, $discord->rest);
    }

    public function testItInitializesCommandHandler()
    {
        $discord = new Discord('::token::', new Bitwise());

        $discord->withCommandHandler();

        $this->assertInstanceOf(CommandHandler::class, $discord->command);
    }

    public function testItInitializesCommandHandlerWithDevGuild()
    {
        $discord = new Discord('::token::', new Bitwise());

        $discord->withCommandHandler('::dev guild id::');

        $this->assertInstanceOf(CommandHandler::class, $discord->command);
    }
}
