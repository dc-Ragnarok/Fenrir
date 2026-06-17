<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

/**
 * @see https://docs.discord.com/developers/components/reference#section
 */
class Section extends Component
{
    /**
     * @var Component[]
     */
    #[ArrayMapping(Component::class)]
    public array $components;

    public Component $accessory;
}
