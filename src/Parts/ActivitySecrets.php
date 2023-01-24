<?php

namespace Exan\Dhp\Parts;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#activity-object-activity-secrets
 */
class ActivitySecrets
{
    public ?string $join;
    public ?string $spectate;
    public ?string $match;
}
