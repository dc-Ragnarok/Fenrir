<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir;

use Exan\Fenrir\Bitwise\Bitwise;
use Exan\Fenrir\CommandHandler;
use Exan\Fenrir\Discord;
use Exan\Fenrir\Gateway;
use Exan\Fenrir\Rest\Rest;
use PHPUnit\Framework\TestCase;

class DiscordTest extends TestCase
{
    public function testItInitializesGateway()
    {
        $discord = new Discord('::token::');

        $discord->withGateway(new Bitwise());

        $this->assertInstanceOf(Gateway::class, $discord->gateway);
    }

    public function testItInitializesRest()
    {
        $discord = new Discord('::token::');

        $discord->withRest();

        $this->assertInstanceOf(Rest::class, $discord->rest);
    }

    public function testItInitializesCommandHandler()
    {
        $discord = new Discord('::token::');

        $discord->withCommandHandler();

        $this->assertInstanceOf(CommandHandler::class, $discord->command);
    }

    public function testItInitializesCommandHandlerWithDevGuild()
    {
        $discord = new Discord('::token::');

        $discord->withCommandHandler('::dev guild id::');

        $this->assertInstanceOf(CommandHandler::class, $discord->command);
    }
}
