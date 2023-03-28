<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Composer\InstalledVersions;
use Discord\Http\DriverInterface;
use Discord\Http\Drivers\Guzzle;
use Discord\Http\Http;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Rest\Rest;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;

class Discord
{
    private LoopInterface $loop;
    private DataMapper $mapper;
    private Http $http;

    public Rest $rest;
    public Gateway $gateway;
    public InteractionHandler $interaction;

    public function __construct(
        private string $token,
        private LoggerInterface $logger = new NullLogger()
    ) {
        $this->loop = Loop::get();

        $this->mapper = new DataMapper($this->logger);
    }

    /**
     * @param Bitwise<\Ragnarok\Fenrir\Enums\Gateway\Intents> $intents
     */
    public function withGateway(
        Bitwise $intents,
        int $timeout = 10,
        bool $raw = false
    ): static {
        $this->gateway = new Gateway(
            $this->loop,
            $this->token,
            $intents,
            $this->mapper,
            $this->logger,
            $timeout,
            $raw
        );

        return $this;
    }

    public function withRest(
        ?DriverInterface $driver = null,
    ): static {
        $driver ??= new Guzzle(
            $this->loop
        );

        $this->http = new Http(
            'Bot ' . $this->token,
            $this->loop,
            $this->logger,
            $driver
        );

        $this->rest = new Rest($this->http, $this->mapper, $this->logger);

        return $this;
    }

    /**
     * @param ?string $devGuildId
     *  When passed, reroute `$this->interaction->registerCommand` to be a Guild
     *  command rather than Global. Useful for testing without having to change
     *  this manually. Explicitly using `registerGlobalCommand` is not affected
     */
    public function withInteractionHandler(?string $devGuildId = null): static
    {
        $args = [$this];

        if (!is_null($devGuildId) && !empty($devGuildId)) {
            $args[] = $devGuildId;
        }

        $this->interaction = new InteractionHandler(...$args);

        return $this;
    }

    public static function getDebugInfo(): array
    {
        try {
            $version = InstalledVersions::getVersion('exan\\fenrir');
        } catch (\OutOfBoundsException) {
            $version = 'Unknown';
        }

        return [
            'fenrir_version' => $version,
            'php_version' => phpversion(),
            'bits' => 8 * PHP_INT_SIZE,
            'uname' => php_uname(),
            'os' => PHP_OS,
            'os_family' => PHP_OS_FAMILY,
        ];
    }
}
