<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Websocket\Events;

use Ragnarok\Fenrir\Parts\Channel;
use Ragnarok\Fenrir\Parts\ThreadMember;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#thread-create
 */
class ThreadCreate extends Channel
{
    public ?bool $newly_created;
    public ?ThreadMember $member;
}
