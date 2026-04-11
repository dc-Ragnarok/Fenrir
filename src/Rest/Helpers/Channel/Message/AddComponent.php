<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Message;

use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentBuilder;

trait AddComponent
{
    private ComponentBuilder $components;

    /**
     * @see https://discord.com/developers/docs/interactions/message-components#component-object
     * @deprecated
     */
    public function setComponents(ComponentBuilder $components): self
    {
        $this->components = $components;

        return $this;
    }

    /**
     * @deprecated
     */
    public function getComponents(): ?ComponentBuilder
    {
        return $this->components ?? null;
    }

    /**
     * @deprecated
     */
    public function hasComponents(): bool
    {
        return isset($this->components);
    }
}
