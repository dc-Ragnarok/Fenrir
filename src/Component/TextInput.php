<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component;

use Ragnarok\Fenrir\Enums\Component\TextInputStyle;

class TextInput extends Component
{
    public function get(): array
    {
        $data = [
            'type' => 4,
            'custom_id' => $this->customId,
            'style' => $this->style,
            'label' => $this->label,
        ];

        if (!is_null($this->minLength)) {
            $data['min_length'] = $this->minLength;
        }

        if (!is_null($this->maxLength)) {
            $data['max_length'] = $this->maxLength;
        }

        if (!is_null($this->required)) {
            $data['required'] = $this->required;
        }

        if (!is_null($this->value)) {
            $data['value'] = $this->value;
        }

        if (!is_null($this->placeholder)) {
            $data['placeholder'] = $this->placeholder;
        }

        return $data;
    }

    public function __construct(
        protected string $customId,
        protected TextInputStyle $style,
        protected string $label,
        protected ?int $minLength = null,
        protected ?int $maxLength = null,
        protected ?bool $required = null,
        protected ?string $value = null,
        protected ?string $placeholder = null
    ) {
    }
}
