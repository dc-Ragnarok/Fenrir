<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#webhooks-update
 */
#[RequiresIntent(Intent::GUILD_WEBHOOKS)]
class WebhooksUpdate
{
    public string $guild_id;
    public string $channel_id;
}
