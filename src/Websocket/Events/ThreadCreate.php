<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\Channel;
use WithOptionalNewlyCreated;
use WithOptionalThreadMember;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#thread-create
 */
class ThreadCreate extends Channel
{
    use WithOptionalNewlyCreated;
    use WithOptionalThreadMember;
}
