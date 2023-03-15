<?php

declare(strict_types=1);

namespace Fakes\Exan\Fenrir;

use Exan\Fenrir\EventHandler;
use Exan\Fenrir\Gateway;
use Exan\Fenrir\Websocket;
use JsonMapper;
use Mockery;
use Mockery\Mock;

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

        $gateway->events = new EventHandler(new JsonMapper(), $raw);
        $gateway->websocket = Mockery::mock(Websocket::class);

        return $gateway;
    }
}
