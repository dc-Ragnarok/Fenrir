<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers\Channel;

use Exan\Finrir\Component\Component;
use Exan\Finrir\Exceptions\Rest\Helpers\ComponentRowBuilder\TooManyItemsException;

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
    public function add(Component $component): ComponentRowBuilder
    {
        if (count($this->components) === 9) {
            throw new TooManyItemsException();
        }

        $this->components[] = $component->get();

        return $this;
    }
}
