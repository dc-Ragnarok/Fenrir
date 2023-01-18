<?php

namespace Exan\Dhp\Component\Button;

use Exan\Dhp\Component\Component;
use Exan\Dhp\Enums\Component\ButtonStyle;
use Exan\Dhp\Parts\Emoji;

abstract class LinkButton extends Component
{
    private ButtonStyle $style = ButtonStyle::Link;

    public function __construct(
        private string $url,
        private ?string $label = null,
        private ?Emoji $emoji = null,
        private bool $disabled = false
    ) { }

    public function get(): array
    {
        $data =  [
            'type' => 2,
            'style' => $this->style,
            'url' => $this->url,
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
