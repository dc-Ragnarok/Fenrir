<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#webhooks-update
 */
class WebhooksUpdate
{
    public string $guild_id;
    public string $channel_id;
}
