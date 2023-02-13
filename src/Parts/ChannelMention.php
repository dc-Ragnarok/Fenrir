<?php

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\ChannelTypes;

class ChannelMention
{
    public string $id;
    public string $guild_id;
    public ChannelTypes $type;
    public string $name;

    public function setType(int $value): void
    {
        $this->type = ChannelTypes::from($value);
    }
}
