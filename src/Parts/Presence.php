<?php

namespace Exan\Dhp\Parts;

class Presence
{
    public User $user;
    public string $guild_id;
    public string $status;
    public array $activities; // @TODO
    public object $client_status; // @TODO
}
