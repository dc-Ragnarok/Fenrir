<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\ChannelType;

class ChannelMention
{
    public string $id;
    public string $guild_id;
    public ChannelType $type;
    public string $name;
}
