<?php

declare(strict_types=1);

namespace Exan\Finrir\Component\Button;

use Exan\Finrir\Enums\Component\ButtonStyle;

class PrimaryButton extends InteractionButton
{
    protected ButtonStyle $style = ButtonStyle::Primary;
}
