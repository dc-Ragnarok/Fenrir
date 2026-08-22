<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

/**
 * @see https://discord.com/developers/docs/resources/subscription#subscription-statuses
 */
enum SubscriptionStatus: int
{
    case ACTIVE = 0;
    case INACTIVE = 1;
    case ENDING = 2;
}
