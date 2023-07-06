<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Carbon\Carbon;
use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#channel-pins-update
 */
#[RequiresIntent(Intent::GUILDS)]
class ChannelPinsUpdate
{
    public ?string $guild_id;
    public string $channel_id;
    public ?Carbon $last_pin_timestamp;
}
