<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

use Exan\Finrir\Parts\Message;
use Exan\Finrir\Parts\Traits\WithMentions;
use Exan\Finrir\Parts\Traits\WithOptionalGuildId;
use Exan\Finrir\Parts\Traits\WithOptionalMember;
use Exan\Finrir\Attributes\Intent;

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
