<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Constants;

class GatewayCloseCodes
{
    public final const LIB_INSTANTIATED_RECONNECT = 1001;
    public final const LIB_INSTANTIATED_RESUME = 1003;

    public final const DESCRIPTIONS = [
        1001 => 'Library instantiated: Reconnect required',
        1003 => 'Library instantiated: Resume required',

        4000 => 'Unknown error',
        4001 => 'Unknown opcode',
        4002 => 'Decode error',
        4003 => 'Not authenticated',
        4004 => 'Authentication failed',
        4005 => 'Already authenticated',
        4007 => 'Invalid sequence',
        4008 => 'Rate limited',
        4009 => 'Session timed out',
        4010 => 'Invalid shard',
        4011 => 'Sharding required',
        4012 => 'Invalid API version',
        4013 => 'Invalid intents',
        4015 => 'Disallowed intents',
    ];

    public final const USER_ERROR = [
        1001 => false,
        1003 => false,

        4000 => true,
        4001 => false,
        4002 => false,
        4003 => false,
        4004 => true,
        4005 => false,
        4007 => false,
        4008 => false,
        4009 => false,
        4010 => true,
        4011 => true,
        4012 => false,
        4013 => true,
        4014 => true,
    ];

    public final const RECOVERABLE = [
        1001 => true,
        1003 => true,

        4000 => true,
        4001 => true,
        4002 => true,
        4003 => true,
        4004 => false,
        4005 => true,
        4007 => true,
        4008 => true,
        4009 => true,
        4010 => false,
        4011 => false,
        4012 => false,
        4013 => false,
        4014 => false,
    ];

    public final const RESUMABLE = [
        1001 => false,
        1003 => true,

        4000 => true,
        4001 => true,
        4002 => true,
        4003 => false,
        4004 => false,
        4005 => true,
        4007 => false,
        4008 => true,
        4009 => false,
        4010 => false,
        4011 => false,
        4012 => false,
        4013 => false,
        4014 => false,
    ];
}
