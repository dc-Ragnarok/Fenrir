<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts\Traits;

use Exan\Finrir\Parts\GuildMember;

/**
 * @todo phase out
 */
trait WithOptionalMember
{
    public ?GuildMember $member;
}
