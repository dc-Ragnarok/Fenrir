<?php

declare(strict_types=1);

namespace Fakes\Ragnarok\Fenrir;

use Exan\Eventer\Eventer;
use Fakes\Ragnarok\Fenrir\DataMapperFake;
use Ragnarok\Fenrir\EventHandler;
use Ragnarok\Fenrir\Websocket;
use Mockery;
use Mockery\MockInterface;
use Ragnarok\Fenrir\Gateway\Connection;

class GatewayFake
{
    /**
     * Returns a partially mocked Gateway instance.
     *  `$gateway->events` is a real `EventHandler` as events
     *  can be emitted with `->emit`. This is often more convenient
     *  than a mock implementation.
     */
    public static function get(): Connection&MockInterface
    {
        /** @var Connection&MockInterface */
        $gateway = Mockery::mock(Connection::class);

        $gateway->events = new EventHandler(DataMapperFake::get());
        $gateway->raw = new Eventer();

        return $gateway;
    }
}
