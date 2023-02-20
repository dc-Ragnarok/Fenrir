<?php

declare(strict_types=1);

namespace Tests\Exan\Finrir;

use Exan\Finrir\Exceptions\Websocket\ConnectionNotInitializedException;
use Exan\Finrir\Websocket;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class WebsocketTest extends TestCase
{
    public function testItThrowsAnErrorForActionsThatRequireConnection()
    {
        $websocket = new Websocket(10, new NullLogger());

        $this->expectException(ConnectionNotInitializedException::class);
        $websocket->close(123, '::reason::');

        $this->expectException(ConnectionNotInitializedException::class);
        $websocket->send('::message::');
    }
}
