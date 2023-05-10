<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir;

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\InteractionHandler;
use Ragnarok\Fenrir\Rest\Rest;
use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Gateway\Connection;

class DiscordTest extends TestCase
{
    public function testItInitializesGateway(): void
    {
        $discord = new Discord('::token::');

        $discord->withGateway(new Bitwise());

        $this->assertInstanceOf(Connection::class, $discord->gateway);
    }

    public function testItInitializesRest(): void
    {
        $discord = new Discord('::token::');

        $discord->withRest();

        $this->assertInstanceOf(Rest::class, $discord->rest);
    }

    public function testItInitializesInteractionHandler(): void
    {
        $discord = new Discord('::token::');

        $discord->withInteractionHandler();

        $this->assertInstanceOf(InteractionHandler::class, $discord->interaction);
    }

    public function testItInitializesInteractionHandlerWithDevGuild(): void
    {
        $discord = new Discord('::token::');

        $discord->withInteractionHandler('::dev guild id::');

        $this->assertInstanceOf(InteractionHandler::class, $discord->interaction);
    }

    public function testGetDebugInfo(): void
    {
        $debugInfo = Discord::getDebugInfo();

        $requirements = [
            'fenrir_version',
            'php_version',
            'bits',
            'uname',
            'os',
            'os_family',
        ];

        foreach ($requirements as $requirement) {
            $this->assertArrayHasKey($requirement, $debugInfo);
        }
    }
}
