<?php

namespace Exan\Dhp\Component\Button;

use Exan\Dhp\Component\Component;
use Exan\Dhp\Enums\Component\ButtonStyle;
use Exan\Dhp\Parts\Emoji;

abstract class InteractionButton extends Component
{
    protected ButtonStyle $style;

    public function __construct(
        protected string $customId,
        protected ?string $label = null,
        protected ?Emoji $emoji = null,
        protected bool $disabled = false
    ) { }

    public function get(): array
    {
        $data =  [
            'type' => 2,
            'style' => $this->style,
            'custom_id' => $this->customId,
            'disabled' => $this->disabled,
        ];

        if (!is_null($this->label)) {
            $data['label'] = $this->label;
        }

        if (!is_null($this->emoji)) {
            $data['emoji'] = $this->emoji;
        }

        return $data;
    }
}
