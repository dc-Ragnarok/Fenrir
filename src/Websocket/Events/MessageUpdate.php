<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Parts\Message;
use Exan\Fenrir\Attributes\Partial;
use Exan\Fenrir\Attributes\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-update
 */
#[Partial, Intent("MESSAGE_CONTENT")]
class MessageUpdate extends Message
{
}
