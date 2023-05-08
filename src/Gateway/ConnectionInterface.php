<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway;

use DateInterval;
use Exan\Eventer\Eventer;
use Ragnarok\Fenrir\EventHandler;
use React\Promise\PromiseInterface;

interface ConnectionInterface
{
    public function getDefaultUrl(): string;

    public function getSequence(): ?int;
    public function setSequence(int $sequence);
    public function resetSequence(): void;

    public function connect(string $url): PromiseInterface;
    public function disconnect(int $code, string $reason): void;

    public function setSessionId(string $sessionId): void;
    public function getSessionId(): ?string;

    public function setResumeUrl(string $resumeUrl): void;
    public function getResumeUrl(): ?string;

    public function sendHeartbeat(): void;
    public function acknowledgeHeartbeat(): void;
    public function startAutomaticHeartbeats(int $ms): void;
    public function stopAutomaticHeartbeats(): void;

    public function getEventHandler(): EventHandler;
    public function getRawHandler(): Eventer;
    public function getMetaHandler(): Eventer;

    public function identify(): void;
    public function resume(): void;
}
