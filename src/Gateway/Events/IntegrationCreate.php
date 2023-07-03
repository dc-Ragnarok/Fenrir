<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\Integration;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#integration-create
 */
#[RequiresIntent(Intent::GUILD_INTEGRATIONS)]
class IntegrationCreate extends Integration
{
    public string $guild_id;
}
