<?php

namespace Exan\Dhp\Rest\Helpers;

use Exan\Dhp\Exceptions\Components\ComponentBuilder\TooManyRowsException;

/**
 * @see https://discord.com/developers/docs/interactions/message-components#component-object
 */
class ComponentBuilder
{
    private array $rows = [];

    public function get(): array
    {
        return $this->rows;
    }

    /**
     * Can not exceed 5 rows
     *
     * @throws TooManyRowsException
     */
    public function addRow(ComponentRowBuilder $componentRow): ComponentBuilder
    {
        if (count($this->rows) === 5) {
            throw new TooManyRowsException();
        }

        $this->rows[] = [
            'type' => 1,
            'components' => $componentRow->get()
        ];

        return $this;
    }
}
