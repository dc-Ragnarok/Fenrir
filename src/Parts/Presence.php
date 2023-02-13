<?php

namespace Exan\Dhp\Parts;

class Presence
{
    public User $user;
    public string $guild_id;
    public string $status;
    /**
     * @var \Exan\Dhp\Enums\Parts\Activity[]
     */
    public ?array $activities;
    public ClientStatus $client_status;
}
