<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

use Ragnarok\Fenrir\Enums\SeparatorSpacing;

/**
 * @see https://docs.discord.com/developers/components/reference#separator
 */
class Separator extends Component
{
    public ?bool $divider;
    public ?SeparatorSpacing $spacing;
}
