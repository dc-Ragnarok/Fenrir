<?php

declare(strict_types=1);

namespace Exan\Finrir\Websocket\Events;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#voice-server-update
 */
class VoiceServerUpdate
{
    public string $token;
    public ?string $guild_id;
    public ?string $endpoint;
}
