<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component\Modal;

/**
 * One choice within a radio group or checkbox group. Both take the same shape.
 *
 * @see https://discord.com/developers/docs/components/reference#radio-group
 */
class Option
{
    public function __construct(
        private readonly string $label,
        private readonly string $value,
        private readonly ?string $description = null,
        private readonly ?bool $default = null
    ) {
    }

    public function get(): array
    {
        $data = [
            'label' => $this->label,
            'value' => $this->value,
        ];

        if (!is_null($this->description)) {
            $data['description'] = $this->description;
        }

        if (!is_null($this->default)) {
            $data['default'] = $this->default;
        }

        return $data;
    }
}
