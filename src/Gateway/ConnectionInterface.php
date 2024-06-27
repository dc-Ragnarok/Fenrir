<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway;

use Exan\Eventer\Eventer;
use Ragnarok\Fenrir\EventHandler;
use Ragnarok\Fenrir\Gateway\Helpers\PresenceUpdateBuilder;
use React\Promise\ExtendedPromiseInterface;

interface ConnectionInterface
{
    public function getDefaultUrl(): string;

    public function getSequence(): ?int;
    public function setSequence(int $sequence);

    public function connect(string $url): ExtendedPromiseInterface;
    public function disconnect(int $code, string $reason): void;

    public function setSessionId(string $sessionId): void;
    public function getSessionId(): ?string;

    public function setResumeUrl(string $resumeUrl): void;
    public function getResumeUrl(): ?string;

    public function sendHeartbeat(): void;
    public function acknowledgeHeartbeat(): void;
    public function startAutomaticHeartbeats(int $ms): void;

    public function getEventHandler(): EventHandler;
    public function getRawHandler(): Eventer;
    public function getMetaHandler(): Eventer;


    public function identify(): void;
    public function resume(): void;

    public function meetsResumeRequirements(): bool;

    public function updatePresence(PresenceUpdateBuilder $presenceUpdate): void;
}
