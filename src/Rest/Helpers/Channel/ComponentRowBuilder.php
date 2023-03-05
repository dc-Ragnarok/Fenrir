<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Component\Component;
use Ragnarok\Fenrir\Exceptions\Rest\Helpers\ComponentRowBuilder\TooManyItemsException;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * Can not exceed 9 components
 *
 * @see https://discord.com/developers/docs/interactions/message-components#component-object
 */
class ComponentRowBuilder
{
    use GetNew;

    private array $components = [];

    public function get(): array
    {
        return $this->components;
    }

    /**
     * @throws TooManyItemsException
     */
    public function add(Component $component): ComponentRowBuilder
    {
        if (count($this->components) === 9) {
            throw new TooManyItemsException();
        }

        $this->components[] = $component->get();

        return $this;
    }
}
