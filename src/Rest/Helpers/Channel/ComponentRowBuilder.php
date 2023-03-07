<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel;

use Exan\Fenrir\Component\Component;
use Exan\Fenrir\Exceptions\Rest\Helpers\ComponentRowBuilder\TooManyItemsException;
use Exan\Fenrir\Rest\Helpers\GetNew;

/**
 * Can not exceed 9 components
 *
 * @see https://discord.com/developers/docs/interactions/message-components#component-object
 */
class ComponentRowBuilder
{
    use GetNew;

    /** @var Component[] */
    private array $components = [];

    public function get(): array
    {
        return array_map(fn (Component $component) => $component->get(), $this->components);
    }

    /**
     * @throws TooManyItemsException
     */
    public function add(Component $component): ComponentRowBuilder
    {
        if (count($this->components) === 9) {
            throw new TooManyItemsException();
        }

        $this->components[] = $component;

        return $this;
    }
}
