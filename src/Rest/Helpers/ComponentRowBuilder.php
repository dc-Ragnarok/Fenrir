<?php

namespace Exan\Dhp\Rest\Helpers;

use Exan\Dhp\Component\Component;
use Exan\Dhp\Exceptions\Components\ComponentRowBuilder\TooManyItemsException;

/**
 * Can not exceed 9 components
 *
 * @see https://discord.com/developers/docs/interactions/message-components#component-object
 */
class ComponentRowBuilder
{
    private array $components = [];

    public function get(): array
    {
        return $this->components;
    }

    /**
     * @throws TooManyItemsException
     */
    public function add(Component $component)
    {
        if (count($this->components) === 9) {
            throw new TooManyItemsException();
        }

        $this->components[] = $component->get();
    }
}
