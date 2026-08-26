<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

/**
 * @see https://discord.com/developers/docs/resources/entitlement#create-test-entitlement
 */
enum EntitlementOwnerType: int
{
    case GUILD_SUBSCRIPTION = 1;
    case USER_SUBSCRIPTION = 2;
}
