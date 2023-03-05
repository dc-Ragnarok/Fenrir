<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Message;

use Exan\Fenrir\Rest\Helpers\Channel\ComponentBuilder;

trait AddComponent
{
    /** @var ComponentBuilder[] */
    private array $components;

    /**
     * @see https://discord.com/developers/docs/interactions/message-components#component-object
     */
    public function addComponent(ComponentBuilder $component): self
    {
        if (!isset($this->components)) {
            $this->components = [];
        }

        $this->components[] = $component;

        return $this;
    }

    /** @return ComponentBuilder[] */
    public function getComponents(): ?array
    {
        return isset($this->components) ? $this->components : null;
    }

    public function hasComponents(): bool
    {
        return isset($this->components);
    }
}
