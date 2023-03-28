<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component\Button;

use Ragnarok\Fenrir\Enums\Component\ButtonStyle;

class DangerButton extends InteractionButton
{
    protected ButtonStyle $style = ButtonStyle::Danger;
}
