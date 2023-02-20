<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Parts\Message;
use Exan\Fenrir\Parts\Traits\WithMentions;
use Exan\Fenrir\Parts\Traits\WithOptionalGuildId;
use Exan\Fenrir\Parts\Traits\WithOptionalMember;
use Exan\Fenrir\Attributes\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-create
 */
#[Intent("MESSAGE_CONTENT")]
class MessageCreate extends Message
{
    use WithOptionalGuildId;
    use WithOptionalMember;
    use WithMentions;
}
