<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component\Button;

use Ragnarok\Fenrir\Component\Component;
use Ragnarok\Fenrir\Enums\Component\ButtonStyle;
use Ragnarok\Fenrir\Rest\Helpers\Emoji\EmojiBuilder;

class LinkButton extends Component
{
    private ButtonStyle $style = ButtonStyle::Link;

    public function __construct(
        private string $url,
        private ?string $label = null,
        private ?EmojiBuilder $emoji = null,
        private bool $disabled = false
    ) {
    }

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
            $data['emoji'] = $this->emoji->get();
        }

        return $data;
    }
}
