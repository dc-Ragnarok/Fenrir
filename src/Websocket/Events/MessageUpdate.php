<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

use Exan\Finrir\Parts\Message;
use Exan\Finrir\Attributes\Partial;
use Exan\Finrir\Attributes\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-update
 */
#[Partial, Intent("MESSAGE_CONTENT")]
class MessageUpdate extends Message
{
}
