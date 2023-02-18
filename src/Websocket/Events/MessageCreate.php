<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Message;
use Exan\Dhp\Parts\Traits\WithMentions;
use Exan\Dhp\Parts\Traits\WithOptionalGuildId;
use Exan\Dhp\Parts\Traits\WithOptionalMember;
use Exan\Dhp\Attributes\Intent;

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
