<?php

declare(strict_types=1);

namespace Exan\Fenrir\Component\SelectMenu;

use Exan\Fenrir\Enums\Component\SelectMenuType;

class UserSelectMenu extends SelectMenu
{
    protected SelectMenuType $type = SelectMenuType::User;
}
