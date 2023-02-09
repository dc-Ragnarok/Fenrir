<?php

namespace Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

use Exan\Dhp\Enums\Parts\ChannelTypes;
use Exan\Dhp\Exceptions\Rest\Helpers\Channel\Channel\Shared\SetType\UnsupportedConversionException;

trait SetType
{
    /**
     * Only supports ChannelTypes::GUILD_TEXT & ChannelTypes::GUILD_ANNOUNCEMENT
     *
     * @throws UnsupportedConversionException
     */
    public function setType(ChannelTypes $type): self
    {
        if (!in_array($type, [ChannelTypes::GUILD_TEXT, ChannelTypes::GUILD_ANNOUNCEMENT])) {
            throw new UnsupportedConversionException();
        }

        $this->data['type'] = $type->value;

        return $this;
    }
}
