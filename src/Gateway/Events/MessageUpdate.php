<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Attributes\Intent;
use Ragnarok\Fenrir\Attributes\Partial;
use Ragnarok\Fenrir\Parts\Message;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-update
 */
#[RequiresIntent(Intent::GUILD_MESSAGES)]
#[RequiresIntent(Intent::DIRECT_MESSAGES)]
class MessageUpdate extends Message
{
}
