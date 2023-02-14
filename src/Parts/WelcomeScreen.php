<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

class WelcomeScreen
{
    public ?string $description;
    /**
     * @var \Exan\Dhp\Parts\WelcomeScreenChannel[]
     */
    public array $welcome_channels;
}
