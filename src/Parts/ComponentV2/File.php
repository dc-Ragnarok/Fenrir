<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

use Ragnarok\Fenrir\Parts\UnfurledMediaItem;

/**
 * @see https://docs.discord.com/developers/components/reference#file
 */
class File extends Component
{
    public UnfurledMediaItem $file;
    public ?bool $spoiler;
    public ?string $name;
    public ?int $size;
}
