<?php

declare(strict_types=1);

namespace Exan\Finrir\Enums\Flags;

enum ApplicationFlags: int
{
    case GATEWAY_PRESENCE = 1 << 12;
    case GATEWAY_PRESENCE_LIMITED = 1 << 13;
    case GATEWAY_GUILD_MEMBERS = 1 << 14;
    case GATEWAY_GUILD_MEMBERS_LIMITED = 1 << 15;
    case VERIFICATION_PENDING_GUILD_LIMIT = 1 << 16;
    case EMBEDDED = 1 << 17;
    case GATEWAY_MESSAGE_CONTENT = 1 << 18;
    case GATEWAY_MESSAGE_CONTENT_LIMITED = 1 << 19;
    case APPLICATION_COMMAND_BADGE = 1 << 23;
}
