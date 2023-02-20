<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

use Exan\Finrir\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#user-update
 */
class UserUpdate extends User
{
}
