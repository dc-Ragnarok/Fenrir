<?php

namespace Exan\Dhp\Component\SelectMenu;

use Exan\Dhp\Enums\Component\SelectMenuType;
use Exan\Dhp\Exceptions\Components\SelectMenu\StringSelectMenu\TooManyOptionsException;
use Exan\Dhp\Parts\Emoji;

class StringSelectMenu extends SelectMenu
{
    protected SelectMenuType $type = SelectMenuType::String;

    protected array $items = [];

    public function __construct(
        protected string $customId,
        protected ?string $placeholder = null,
        protected int $minValues = 1,
        protected int $maxValues = 25,
        protected bool $disabled = false
    ) {
        parent::__construct(
            $customId,
            $placeholder,
            $minValues,
            $maxValues,
            $disabled
        );
    }

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
            $item['emoji'] = $emoji;
        }

        if (!is_null($default)) {
            $item['defaul$default'] = $default;
        }

        $this->items[] = $item;
    }

    public function get(): array
    {
        return array_merge(parent::get(), ['items' => $this->items]);
    }
}
