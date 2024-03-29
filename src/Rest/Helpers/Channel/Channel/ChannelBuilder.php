<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Channel;

use Ragnarok\Fenrir\Enums\ChannelType;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://discord.com/developers/docs/resources/channel#modify-channel
 */
abstract class ChannelBuilder
{
    use GetNew;

    protected array $data = [];

    public function get(): array
    {
        return $this->data;
    }

    public function setName(string $name): self
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function setPosition(int $position): self
    {
        $this->data['position'] = $position;

        return $this;
    }

    /**
     * @todo Overwrite builder
     */
    // public function addPermissionOverwrites(Overwrite $overwrite): self
    // {
    //     if (!isset($this->data['permission_overwrites'])) {
    //         $this->data['permission_overwrites'] = [];
    //     }

    //     $this->data['permission_overwrites'][] = $overwrite->toArray();

    //     return $this;
    // }

    protected function setChannelType(ChannelType $type): self
    {
        $this->data['type'] = $type->value;

        return $this;
    }
}
