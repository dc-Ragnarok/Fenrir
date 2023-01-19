<?php

namespace Exan\Dhp\Component\SelectMenu;

use Exan\Dhp\Enums\Component\SelectMenuType;
use Exan\Dhp\Exceptions\Components\SelectMenu\StringSelectMenu\NoOptionsException;
use Exan\Dhp\Exceptions\Components\SelectMenu\StringSelectMenu\TooManyOptionsException;
use Exan\Dhp\Parts\Emoji;

class StringSelectMenu extends SelectMenu
{
    protected SelectMenuType $type = SelectMenuType::String;

    protected array $items = [];

    /**
     * Can not exceed 25 options
     *
     * @throws TooManyOptionsException
     */
    public function addOption(
        string $label,
        string $value,
        ?string $description = null,
        ?Emoji $emoji = null,
        ?bool $default = null
    ) {
        if (count($this->items) === 25) {
            throw new TooManyOptionsException();
        }

        $item = [
            'label' => $label,
            'value' => $value,
        ];

        if (!is_null($description)) {
            $item['description'] = $description;
        }

        if (!is_null($emoji)) {
            $item['emoji'] = $emoji->getPartial();
        }

        if (!is_null($default)) {
            $item['default'] = $default;
        }

        $this->items[] = $item;
    }

    /**
     * @throws NoOptionsException
     */
    public function get(): array
    {
        if (count($this->items) === 0) {
            throw new NoOptionsException();
        }

        return array_merge(parent::get(), ['options' => $this->items]);
    }
}
