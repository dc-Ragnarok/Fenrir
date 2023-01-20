<?php

declare(strict_types=1);

namespace Exan\Dhp\Component\Button;

use Exan\Dhp\Enums\Component\ButtonStyle;

class DangerButton extends InteractionButton
{
    protected ButtonStyle $style = ButtonStyle::Danger;
}
