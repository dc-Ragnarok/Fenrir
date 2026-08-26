<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Enums\SkuType;

/**
 * @see https://discord.com/developers/docs/resources/sku#sku-object
 */
class Sku
{
    public string $id;
    public SkuType $type;
    public string $application_id;
    public string $name;
    public string $slug;
    public Bitwise $flags;
}
