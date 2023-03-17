<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir;

use Exan\Fenrir\Bitwise\Bitwise;
use Exan\Fenrir\Discord;
use Exan\Fenrir\Gateway;
use Exan\Fenrir\InteractionHandler;
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

    public function testItInitializesInteractionHandler()
    {
        $discord = new Discord('::token::');

        $discord->withInteractionHandler();

        $this->assertInstanceOf(InteractionHandler::class, $discord->interaction);
    }

    public function testItInitializesInteractionHandlerWithDevGuild()
    {
        $discord = new Discord('::token::');

        $discord->withInteractionHandler('::dev guild id::');

        $this->assertInstanceOf(InteractionHandler::class, $discord->interaction);
    }
}
