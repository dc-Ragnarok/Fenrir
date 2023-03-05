<?php

declare(strict_types=1);

namespace Exan\Fenrir\Component\Button;

use Exan\Fenrir\Enums\Component\ButtonStyle;

class DangerButton extends InteractionButton
{
    protected ButtonStyle $style = ButtonStyle::Danger;
}
