<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\Guild;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-delete
 */
#[RequiresIntent(Intent::GUILDS)]
class GuildDelete extends Guild
{
}
