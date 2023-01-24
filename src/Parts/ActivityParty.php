<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#activity-object-activity-party
 */
class ActivityParty
{
    public string $id;
    public array $size;
}
