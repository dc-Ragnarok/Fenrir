<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

class WelcomeScreen
{
    public ?string $description;
    /**
     * @var \Exan\Finrir\Parts\WelcomeScreenChannel[]
     */
    public array $welcome_channels;
}
