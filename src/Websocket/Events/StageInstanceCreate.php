<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#stage-instance-create
 */
class StageInstanceCreate
{
    public string $token;
    public string $guild_id;
    public ?string $endpoint;
}
