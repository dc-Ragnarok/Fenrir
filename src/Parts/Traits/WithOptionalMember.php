<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts\Traits;

use Exan\Dhp\Parts\GuildMember;

/**
 * @todo phase out
 */
trait WithOptionalMember
{
    public ?GuildMember $member;
}
