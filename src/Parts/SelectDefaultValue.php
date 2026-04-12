<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

/**
 * @see https://docs.discord.com/developers/components/reference#user-select-select-default-value-structure
 */
class SelectDefaultValue
{
    public string $id;
    public string $type; // @todo components-v2 enum
}
