<?php

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Message;
use Exan\Dhp\Parts\Traits\WithMentions;
use Exan\Dhp\Parts\Traits\WithOptionalGuildId;
use Exan\Dhp\Parts\Traits\WithOptionalMember;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-create
 */
class MessageCreate extends Message
{
    use WithOptionalGuildId;
    use WithOptionalMember;
    use WithMentions;
}
