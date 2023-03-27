<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Websocket\Events;

use Ragnarok\Fenrir\Parts\VoiceState;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#voice-state-update
 */
class VoiceStateUpdate extends VoiceState
{
}
