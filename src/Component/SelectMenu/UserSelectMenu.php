<?php

declare(strict_types=1);

namespace Exan\Finrir\Component\SelectMenu;

use Exan\Finrir\Enums\Component\SelectMenuType;

class UserSelectMenu extends SelectMenu
{
    protected SelectMenuType $type = SelectMenuType::User;
}
