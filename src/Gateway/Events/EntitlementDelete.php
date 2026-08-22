<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Parts\Entitlement;

/**
 * Entitlement events are not gated behind an intent.
 *
 * @see https://discord.com/developers/docs/events/gateway-events#entitlement-delete
 */
class EntitlementDelete extends Entitlement
{
}
