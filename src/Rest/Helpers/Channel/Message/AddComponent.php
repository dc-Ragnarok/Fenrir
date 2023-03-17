<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Message;

use Exan\Fenrir\Rest\Helpers\Channel\ComponentBuilder;

trait AddComponent
{
    private ComponentBuilder $components;

    /**
     * @see https://discord.com/developers/docs/interactions/message-components#component-object
     */
    public function setComponents(ComponentBuilder $components): self
    {
        $this->components = $components;

        return $this;
    }

    public function getComponents(): ?ComponentBuilder
    {
        return $this->components ?? null;
    }

    public function hasComponents(): bool
    {
        return isset($this->components);
    }
}
