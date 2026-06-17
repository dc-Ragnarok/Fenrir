<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Message;

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Enums\MessageFlag;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentV2Builder;

trait AddComponent
{
    private ComponentBuilder|ComponentV2Builder $components;

    /**
     * @see https://discord.com/developers/docs/interactions/message-components#component-object
     */
    public function setComponents(ComponentBuilder|ComponentV2Builder $components): self
    {
        $this->components = $components;

        return $this;
    }

    public function getComponents(): null|ComponentBuilder|ComponentV2Builder
    {
        return $this->components ?? null;
    }

    public function hasComponents(): bool
    {
        return isset($this->components);
    }

    public function componentFlags(): Bitwise
    {
        if (!isset($this->components) || $this->components instanceof ComponentBuilder) {
            return new Bitwise(0);
        }

        return new Bitwise(MessageFlag::IS_COMPONENTS_V2->value);
    }
}
