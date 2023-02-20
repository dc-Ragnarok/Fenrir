<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

use Exan\Finrir\Parts\Channel;
use Exan\Finrir\Parts\Traits\WithOptionalNewlyCreated;
use Exan\Finrir\Parts\Traits\WithOptionalThreadMember;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#thread-create
 */
class ThreadCreate extends Channel
{
    use WithOptionalNewlyCreated;
    use WithOptionalThreadMember;
}
