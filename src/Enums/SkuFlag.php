<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

/**
 * @see https://discord.com/developers/docs/resources/sku#sku-object-sku-flags
 */
enum SkuFlag: int
{
    case AVAILABLE = 1 << 2;
    case GUILD_SUBSCRIPTION = 1 << 7;
    case USER_SUBSCRIPTION = 1 << 8;
}
