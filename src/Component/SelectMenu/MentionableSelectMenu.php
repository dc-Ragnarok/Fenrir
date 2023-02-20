<?php

declare(strict_types=1);

namespace Exan\Fenrir\Component\SelectMenu;

use Exan\Fenrir\Enums\Component\SelectMenuType;

class MentionableSelectMenu extends SelectMenu
{
    protected SelectMenuType $type = SelectMenuType::Mentionable;
}
