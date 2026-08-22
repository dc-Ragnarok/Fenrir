<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

/**
 * @see https://discord.com/developers/docs/resources/entitlement#entitlement-object-entitlement-types
 */
enum EntitlementType: int
{
    case PURCHASE = 1;
    case PREMIUM_SUBSCRIPTION = 2;
    case DEVELOPER_GIFT = 3;
    case TEST_MODE_PURCHASE = 4;
    case FREE_PURCHASE = 5;
    case USER_GIFT = 6;
    case PREMIUM_PURCHASE = 7;
    case APPLICATION_SUBSCRIPTION = 8;
}
