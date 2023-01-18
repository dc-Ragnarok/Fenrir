<?php

namespace Exan\Dhp\Component\Button;

use Exan\Dhp\Enums\Component\ButtonStyle;

class PrimaryButton extends InteractionButton
{
    protected ButtonStyle $style = ButtonStyle::Primary;
}
