<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Ragnarok\Fenrir\Enums\ChannelType;
use Ragnarok\Fenrir\Exceptions\Rest\Helpers\Channel\Channel\Shared\SetType\UnsupportedConversionException;

trait SetType
{
    /**
     * Only supports ChannelType::GUILD_TEXT & ChannelType::GUILD_ANNOUNCEMENT
     *
     * @throws UnsupportedConversionException
     */
    public function setType(ChannelType $type): self
    {
        if (!in_array($type, [ChannelType::GUILD_TEXT, ChannelType::GUILD_ANNOUNCEMENT])) {
            throw new UnsupportedConversionException();
        }

        $this->data['type'] = $type->value;

        return $this;
    }

    public function getType(): ?ChannelType
    {
        return isset($this->data['type'])
            ? ChannelType::from($this->data['type'])
            : null;
    }
}
