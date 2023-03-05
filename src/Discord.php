<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Discord\Http\Drivers\Guzzle;
use Discord\Http\Http;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Rest\Rest;
use JsonMapper;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;

class Discord
{
    private LoopInterface $loop;
    private JsonMapper $mapper;
    private Http $http;

    public Rest $rest;
    public Gateway $gateway;
    public CommandHandler $command;

    public function __construct(
        private string $token,
        private Bitwise $intents,
        private LoggerInterface $logger = new NullLogger()
    ) {
        $this->loop = Loop::get();

        $this->mapper = new JsonMapper();
        $this->mapper->bStrictNullTypes = false;
    }

    public function withGateway(
        int $timeout = 10,
        bool $raw = false
    ) {
        $this->gateway = new Gateway(
            $this->loop,
            $this->token,
            $this->intents,
            $this->mapper,
            $this->logger,
            $timeout,
            $raw
        );

        return $this;
    }

    public function withRest()
    {
        $this->http = new Http(
            'Bot ' . $this->token,
            $this->loop,
            $this->logger,
            new Guzzle(
                $this->loop
            )
        );

        $this->rest = new Rest($this->http, $this->mapper);

        return $this;
    }

    /**
     * @param ?string $devGuildId
     *  When passed, reroute `$this->$command->registerCommand` to be a Guild
     *  command rather than Global. Useful for testing without having to change
     *  this manually. Explicitly using `registerGlobalCommand` is not affected
     */
    public function withCommandHandler(
        ?string $devGuildId = null
    ) {
        $args = [$this];

        if (!is_null($devGuildId) && !empty($devGuildId)) {
            $args[] = $devGuildId;
        }

        $this->command = new CommandHandler(...$args);

        return $this;
    }
}
