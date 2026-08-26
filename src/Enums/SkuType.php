<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

/**
 * @see https://discord.com/developers/docs/resources/sku#sku-object-sku-types
 */
enum SkuType: int
{
    case DURABLE = 2;
    case CONSUMABLE = 3;
    case SUBSCRIPTION = 5;
    case SUBSCRIPTION_GROUP = 6;
}
