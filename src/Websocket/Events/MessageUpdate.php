<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Websocket\Events;

use Ragnarok\Fenrir\Parts\Message;
use Ragnarok\Fenrir\Attributes\Partial;
use Ragnarok\Fenrir\Attributes\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-update
 */
#[Partial, Intent("MESSAGE_CONTENT")]
class MessageUpdate extends Message
{
}
