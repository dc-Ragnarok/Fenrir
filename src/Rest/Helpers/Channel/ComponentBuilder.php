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

    /** @var ComponentRowBuilder[] */
    private array $rows = [];

    public function get(): array
    {
        return array_map(fn (ComponentRowBuilder $row) => [
            'type' => 1,
            'components' => $row->get()
        ], $this->rows);
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

        $this->rows[] = $componentRow;

        return $this;
    }

    public function getRows()
    {
        return $this->rows;
    }
}
