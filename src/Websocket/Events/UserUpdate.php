<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#user-update
 */
class UserUpdate extends User
{
}
