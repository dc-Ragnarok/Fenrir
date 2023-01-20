<?php

declare(strict_types=1);

namespace Exan\Dhp\Websocket\Events;

use Exan\Dhp\Parts\VoiceState;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#voice-state-update
 */
class VoiceStateUpdate extends VoiceState
{
}
