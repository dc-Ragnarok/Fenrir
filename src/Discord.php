<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir;

use Composer\InstalledVersions;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Enums\TokenType;
use Ragnarok\Fenrir\Exceptions\Extension\ExtensionNotFoundException;
use Ragnarok\Fenrir\Extension\Extension;
use Ragnarok\Fenrir\Gateway\Connection;
use Ragnarok\Fenrir\Http\HttpClient;
use Ragnarok\Fenrir\Http\HttpScheduler;
use Ragnarok\Fenrir\Rest\Rest;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;
use React\Http\Browser;

class Discord
{
    private LoopInterface $loop;
    private DataMapper $mapper;
    private HttpScheduler $http;

    public Rest $rest;
    public Connection $gateway;

    private array $extensions;

    public function __construct(
        private string $token,
        private LoggerInterface $logger = new NullLogger(),
        ?LoopInterface $loop = null,
        ?DataMapper $dataMapper = null,
    ) {
        $this->logger->info('Fenrir initialized. Discriminators > usernames');

        $this->loop = $loop ?? Loop::get();

        $this->mapper = $dataMapper ?? new DataMapper(new NullLogger());
    }

    /**
     * @param Bitwise<\Ragnarok\Fenrir\Enums\Intent> $intents
     */
    public function withGateway(
        Bitwise $intents,
        int $timeout = 10
    ): static {
        $this->gateway = new Connection(
            $this->loop,
            $this->token,
            $intents,
            $this->mapper,
            new Websocket($timeout, $this->logger, [$this->token => '::token::']),
            $this->logger,
        );

        return $this;
    }

    public function withRest(
        ?Browser $browser = null,
        TokenType $tokenType = TokenType::BOT,
    ): static {
        $browser ??= new Browser(loop: $this->loop);

        $this->http = new HttpScheduler(
            $this->loop,
            new HttpClient($browser, $tokenType->value . ' ' . $this->token),
            $this->logger,
        );

        $this->rest = new Rest($this->http, $this->mapper, $this->logger);

        return $this;
    }

    public static function getDebugInfo(): array
    {
        try {
            $version = InstalledVersions::getVersion('exan/fenrir');
        } catch (\OutOfBoundsException) {
            $version = 'Unknown';
        }

        return [
            'fenrir_version' => $version,
            'php_version' => PHP_VERSION,
            'bits' => 8 * PHP_INT_SIZE,
            'uname' => php_uname(),
            'os' => PHP_OS,
            'os_family' => PHP_OS_FAMILY,
        ];
    }

    /**
     * @template E
     *
     * @param class-string<E>
     * @return E
     *
     * @throws ExtensionNotFoundException
     */
    public function getExtension(string $id): Extension
    {
        if (!$this->hasExtension($id)) {
            throw new ExtensionNotFoundException(sprintf('Extension %s not found', $id));
        }

        return $this->extensions[$id];
    }

    public function hasExtension(string $id): bool
    {
        return isset($this->extensions[$id]);
    }

    public function registerExtension(Extension $extension): void
    {
        $extension->initialize($this);

        $this->extensions[get_class($extension)] = $extension;
    }
}
