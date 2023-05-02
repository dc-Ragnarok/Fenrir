<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

class Presence
{
    public User $user;
    public string $guild_id;
    public string $status;
    /**
     * @var Activity[]
     */
    public ?array $activities;
    public ClientStatus $client_status;
}
