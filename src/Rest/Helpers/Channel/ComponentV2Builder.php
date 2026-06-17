<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://docs.discord.com/developers/components/overview#components-overview
 */
class ComponentV2Builder
{
    use GetNew;

    public function get(): array
    {
        return [];
    }
}
