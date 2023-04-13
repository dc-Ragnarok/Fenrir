<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\DataMapper;
use Ragnarok\Fenrir\Gateway;
use Ragnarok\Fenrir\Websocket;
use React\EventLoop\Loop;

class GatewayTest extends MockeryTestCase
{
    private function getGateway(): Gateway
    {
        $gateway = new Gateway(
            Loop::get(),
            '::token::',
            new Bitwise(),
            new DataMapper(new NullLogger())
        );

        $gateway->websocket = Mockery::mock(Websocket::class)->makePartial();

        return $gateway;
    }

    public function testItConnectsToWebsocket()
    {
        $gateway = $this->getGateway();
        /** @var Websocket&MockInterface */
        $websocket = &$gateway->websocket;

        $websocket->expects()
            ->open()
            ->with(Gateway::WEBSOCKET_URL)
            ->once();

        $gateway->connect();
    }

    // public function testItSendsIdentifyPayload()
    // {

    // }
}
