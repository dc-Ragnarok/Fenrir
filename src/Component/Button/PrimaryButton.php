<?php

declare(strict_types=1);

namespace Exan\Fenrir\Component\Button;

use Exan\Fenrir\Enums\Component\ButtonStyle;

class PrimaryButton extends InteractionButton
{
    protected ButtonStyle $style = ButtonStyle::Primary;
}
