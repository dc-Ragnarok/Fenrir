<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\Channel;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#channel-update
 */
#[RequiresIntent(Intent::GUILDS)]
class ChannelUpdate extends Channel
{
}
