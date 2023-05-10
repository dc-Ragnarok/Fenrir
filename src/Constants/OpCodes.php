<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Constants;

class OpCodes
{
    public const EVENTS = '0';
    public const HEARTBEAT = '1';
    public const IDENTIFY = '2';
    public const GATEWAY_PRESENCE_UPDATE = '3';
    public const GATEWAY_VOICE_STATE = '4';
    public const SPEAKING_INDICATOR = '5';
    public const RESUME = '6';
    public const RECONNECT = '7';
    public const GUILD_REQUEST_MEMBERS = '8';
    public const INVALID_SESSION = '9';
    public const HELLO = '10';
    public const HEARTBEAT_ACKNOWLEDGEMENT = '11';
}
