<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#user-update
 */
class UserUpdate extends User
{
}
