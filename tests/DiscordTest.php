<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir;

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Gateway;
use Ragnarok\Fenrir\InteractionHandler;
use Ragnarok\Fenrir\Rest\Rest;
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

    public function testGetDebugInfo()
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
