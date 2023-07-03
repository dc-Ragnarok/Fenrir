<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#integration-delete
 */
#[RequiresIntent(Intent::GUILD_INTEGRATIONS)]
class IntegrationDelete
{
    public string $id;
    public string $guild_id;
    public ?string $application_id;
}
