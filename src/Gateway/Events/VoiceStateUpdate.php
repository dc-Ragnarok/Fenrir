<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\VoiceState;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#voice-state-update
 */
#[RequiresIntent(Intent::GUILD_VOICE_STATES)]
class VoiceStateUpdate extends VoiceState
{
}
