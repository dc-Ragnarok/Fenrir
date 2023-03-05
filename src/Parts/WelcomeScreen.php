<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

class WelcomeScreen
{
    public ?string $description;
    /**
     * @var \Exan\Fenrir\Parts\WelcomeScreenChannel[]
     */
    public array $welcome_channels;
}
