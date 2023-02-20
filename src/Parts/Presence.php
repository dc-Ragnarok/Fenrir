<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

class Presence
{
    public User $user;
    public string $guild_id;
    public string $status;
    /**
     * @var \Exan\Finrir\Parts\Activity[]
     */
    public ?array $activities;
    public ClientStatus $client_status;
}
