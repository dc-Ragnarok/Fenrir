<?php

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Message;
use Exan\Dhp\Parts\Traits\WithOptionalGuildId;
use Exan\Dhp\Parts\Traits\WithOptionalMember;
use WithMentions;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-create
 */
class MessageCreate extends Message
{
    use WithOptionalGuildId;
    use WithOptionalMember;
    use WithMentions;
}
