<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

use Ragnarok\Fenrir\Enums\TextInputStyle;

/**
 * @see https://docs.discord.com/developers/components/reference#text-input
 */
class TextInput extends Component
{
    public string $custom_id;
    public TextInputStyle $style;
    public ?int $min_length;
    public ?int $max_length;
    public ?bool $required;
    public ?string $value;
    public ?string $placeholder;
}
