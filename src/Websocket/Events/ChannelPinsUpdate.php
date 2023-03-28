<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Websocket\Events;

use Carbon\Carbon;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#channel-pins-update
 */
class ChannelPinsUpdate
{
    public ?string $guild_id;
    public string $channel_id;
    public ?Carbon $last_pin_timestamp;
}
