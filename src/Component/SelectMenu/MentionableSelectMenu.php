<?php

declare(strict_types=1);

namespace Exan\Finrir\Component\SelectMenu;

use Exan\Finrir\Enums\Component\SelectMenuType;

class MentionableSelectMenu extends SelectMenu
{
    protected SelectMenuType $type = SelectMenuType::Mentionable;
}
