<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

use Ragnarok\Fenrir\Parts\Emoji;

/**
 * @see https://docs.discord.com/developers/components/reference#button
 */
class Button extends Component
{
    public int $style; // @todo components-v2 enum
    public ?string $label;
    public ?Emoji $string;
    public ?string $custom_id;
    public ?string $snowflake;
    public ?string $url;
    public ?bool $disabled;
}
