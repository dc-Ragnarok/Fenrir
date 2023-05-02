<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

class WelcomeScreen
{
    public ?string $description;
    /**
     * @var \Ragnarok\Fenrir\Parts\WelcomeScreenChannel[]
     */
    public array $welcome_channels;
}
