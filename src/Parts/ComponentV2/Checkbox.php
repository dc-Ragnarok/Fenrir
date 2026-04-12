<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

/**
 * @see https://docs.discord.com/developers/components/reference#checkbox
 */
class Checkbox extends Component
{
    public ?string $custom_id;
    public ?bool $default;
}
