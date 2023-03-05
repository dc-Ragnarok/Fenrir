<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Exceptions\Rest\Helpers\ComponentBuilder\TooManyRowsException;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://discord.com/developers/docs/interactions/message-components#component-object
 */
class ComponentBuilder
{
    use GetNew;

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
