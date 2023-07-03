<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#stage-instance-update
 */
#[RequiresIntent(Intent::GUILDS)]
class StageInstanceUpdate
{
    public string $token;
    public string $guild_id;
    public ?string $endpoint;
}
