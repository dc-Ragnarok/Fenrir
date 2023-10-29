<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

class WelcomeScreen
{
    public ?string $description;
    /**
     * @var WelcomeScreenChannel[]
     */
    #[ArrayMapping(WelcomeScreenChannel::class)]
    public array $welcome_channels;
}
