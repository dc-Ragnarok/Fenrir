<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Emoji;
use Exan\Dhp\Parts\Member;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#message-reaction-add
 */
class MessageReactionAdd
{
    public string $user_id;
    public string $channel_id;
    public string $message_id;
    public ?string $guild_id;
    public ?Member $member;
    public Emoji $emoji;
}
