<?php

declare(strict_types=1);

namespace Fakes\Ragnarok\Fenrir;

use Ragnarok\Fenrir\DataMapper;
use Fakes\Ragnarok\Fenrir\DataMapperFake;
use Ragnarok\Fenrir\EventHandler;
use Ragnarok\Fenrir\Gateway;
use Ragnarok\Fenrir\Websocket;
use Mockery;
use Mockery\Mock;
use Psr\Log\NullLogger;

class GatewayFake
{
    /**
     * Returns a partially mocked Gateway instance.
     *  `$gateway->events` is a real `EventHandler` as events
     *  can be emitted with `->emit`. This is often more convenient
     *  than a mock implementation.
     *
     * @param bool $raw Whether the EventHandler should emit raw events
     */
    public static function get(bool $raw = true): Mock|Gateway
    {
        $gateway = Mockery::mock(Gateway::class);

        $gateway->events = new EventHandler(DataMapperFake::get(), $raw);
        $gateway->websocket = Mockery::mock(Websocket::class);

        return $gateway;
    }
}
