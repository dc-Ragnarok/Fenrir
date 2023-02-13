<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts\Traits;

use Exan\Dhp\Parts\GuildMember;

trait WithOptionalMember
{
    public ?GuildMember $member;
}
