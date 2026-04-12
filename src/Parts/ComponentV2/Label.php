<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

/**
 * @see https://docs.discord.com/developers/components/reference#label
 */
class Label extends Component
{
    public string $label;
    public ?string $description;
    public $component; // @todo components-v2 add component mapping
}
