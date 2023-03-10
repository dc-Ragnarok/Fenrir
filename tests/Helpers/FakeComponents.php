<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Helpers;

use Exan\Fenrir\CommandHandler;
use Exan\Fenrir\Discord;
use Exan\Fenrir\EventHandler;
use Exan\Fenrir\Gateway;
use Exan\Fenrir\Rest\Rest;
use Exan\Fenrir\Websocket;
use JsonMapper;
use Mockery;
use Mockery\Mock;
use React\Promise\ExtendedPromiseInterface;
use React\Promise\Promise;
use ReflectionClass;

class FakeComponents
{
    public static function getFakeDiscord(): Mock|Discord
    {
        $discord = Mockery::mock(Discord::class);

        $discord->rest = self::getFakeRest();
        $discord->gateway = self::getFakeGateway();
        $discord->command = self::getFakeCommandHandler();

        return $discord;
    }

    /**
     * Returns a partially mocked Gateway instance.
     *  `$gateway->events` is a real `EventHandler` as events
     *  can be emitted with `->emit`. This is often more convenient
     *  than a mock implementation.
     *
     * @param bool $raw Whether the EventHandler should emit raw events
     */
    public static function getFakeGateway(bool $raw = true): Mock|Gateway
    {
        $gateway = Mockery::mock(Gateway::class);

        $gateway->events = new EventHandler(new JsonMapper(), $raw);
        $gateway->websocket = Mockery::mock(Websocket::class);

        return $gateway;
    }

    public static function getFakeRest(): Mock|Rest
    {
        $restMock = Mockery::mock(Rest::class);

        $reflectionClass = new ReflectionClass(Rest::class);

        foreach ($reflectionClass->getProperties() as $property) {
            if (!$property->isPublic()) {
                continue;
            }

            $restMock->{$property->getName()} = Mockery::mock($property->getType()->getName());
        }

        return $restMock;
    }

    public static function getFakeCommandHandler(): Mock|CommandHandler
    {
        $commandHandler = Mockery::mock(CommandHandler::class);

        return $commandHandler;
    }

    /**
     * Returns a promise which resolves immediately
     *
     * @param mixed $return What the promise should resolve to
     */
    public static function getFakePromise(mixed $return = null): ExtendedPromiseInterface
    {
        return new Promise(function ($resolve) use ($return) {
            $resolve($return);
        });
    }
}
