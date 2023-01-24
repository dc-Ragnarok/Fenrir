<?php

namespace Exan\Dhp\Parts;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#presence-update-presence-update-event-fields
 * @todo
 */
class Presence
{
    public User $user;
    public string $guild_id;
    public string $status;
    public array $activities; // @TODO
    public object $client_status; // @TODO
}
