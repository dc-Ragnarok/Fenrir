<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\Intent;
use Ragnarok\Fenrir\Attributes\Partial;
use Ragnarok\Fenrir\Parts\Message;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-update
 */
#[Partial, Intent("MESSAGE_CONTENT")]
class MessageUpdate extends Message
{
}
