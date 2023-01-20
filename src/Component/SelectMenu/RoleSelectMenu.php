<?php

declare(strict_types=1);

namespace Exan\Dhp\Component\SelectMenu;

use Exan\Dhp\Enums\Component\SelectMenuType;

class RoleSelectMenu extends SelectMenu
{
    protected SelectMenuType $type = SelectMenuType::Role;
}
