<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Parts\Channel;
use Exan\Fenrir\Parts\Traits\WithOptionalNewlyCreated;
use Exan\Fenrir\Parts\Traits\WithOptionalThreadMember;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#thread-create
 */
class ThreadCreate extends Channel
{
    use WithOptionalNewlyCreated;
    use WithOptionalThreadMember;
}
