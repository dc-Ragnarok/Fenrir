<?php

declare(strict_types=1);

namespace Exan\Dhp\Component\SelectMenu;

use Exan\Dhp\Enums\Component\SelectMenuType;

class UserSelectMenu extends SelectMenu
{
    protected SelectMenuType $type = SelectMenuType::User;
}
