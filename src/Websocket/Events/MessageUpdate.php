<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Message;
use Exan\Dhp\Attributes\Partial;
use Exan\Dhp\Attributes\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-update
 */
#[Partial, Intent("MESSAGE_CONTENT")]
class MessageUpdate extends Message
{
}
