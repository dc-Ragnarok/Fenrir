<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Discord;
use Ragnarok\Fenrir\Exceptions\Extension\ExtensionNotFoundException;
use Ragnarok\Fenrir\InteractionHandler;
use Ragnarok\Fenrir\Rest\Rest;
use Ragnarok\Fenrir\Extension\Extension;
use Ragnarok\Fenrir\Gateway\Connection;

class DiscordTest extends MockeryTestCase
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

    public function testItCanInitializeExtensions(): void
    {
        /**
         * @var Extension|MockInterface
         */
        $extension = Mockery::mock(Extension::class);

        $discord = new Discord('TOKEN');

        $extension->expects()
            ->initialize()
            ->with($discord)
            ->once();

        $discord->registerExtension($extension);
    }

    public function testItTellsYouWhetherExtensionsAreInstalled(): void
    {
        $extension = new class () implements Extension {
            public function initialize(Discord $discord): void
            {
            }
        };

        $discord = new Discord('TOKEN');

        $this->assertFalse($discord->hasExtension(get_class($extension)));

        $discord->registerExtension($extension);

        $this->assertTrue($discord->hasExtension(get_class($extension)));
    }

    public function testItReturnsTheExtension(): void
    {
        $extension = new class () implements Extension {
            public function initialize(Discord $discord): void
            {
            }
        };

        $discord = new Discord('TOKEN');

        $discord->registerExtension($extension);

        $this->assertEquals($extension, $discord->getExtension(get_class($extension)));
    }

    public function testItYellsWhenYouTryToReturnANonRegisteredExtension(): void
    {
        $extension = new class () implements Extension {
            public function initialize(Discord $discord): void
            {
            }
        };

        $discord = new Discord('TOKEN');

        $this->expectException(ExtensionNotFoundException::class);

        $this->assertEquals($extension, $discord->getExtension(get_class($extension)));
    }
}
