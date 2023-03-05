<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Exan\Fenrir\Enums\Parts\ChannelTypes;
use Exan\Fenrir\Exceptions\Rest\Helpers\Channel\Channel\Shared\SetType\UnsupportedConversionException;

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
