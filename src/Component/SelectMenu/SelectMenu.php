<?php

namespace Exan\Dhp\Component\SelectMenu;

use Exan\Dhp\Component\Component;
use Exan\Dhp\Enums\Component\SelectMenuType;

abstract class SelectMenu extends Component
{
    protected SelectMenuType $type;

    public function __construct(
        protected string $customId,
        protected ?string $placeholder = null,
        protected int $minValues = 1,
        protected int $maxValues = 25,
        protected bool $disabled = false
    ) { }

    public function get(): array
    {
        $data = [
            'type' => $this->type,
            'custom_id' => $this->customId,
            'min_values' => $this->minValues,
            'max_values' => $this->maxValues,
            'disabled' => $this->disabled
        ];

        if (!is_null($this->placeholder)) {
            $data['placeholder'] = $this->placeholder;
        }

        return $data;
    }
}
