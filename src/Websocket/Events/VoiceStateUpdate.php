<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Parts\VoiceState;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#voice-state-update
 */
class VoiceStateUpdate extends VoiceState
{
}
