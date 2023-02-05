<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\ConnectionStatus;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#client-status-object
 */
class ClientStatus
{
    public ?ConnectionStatus $desktop;
    public ?ConnectionStatus $mobile;
    public ?ConnectionStatus $web;
}
