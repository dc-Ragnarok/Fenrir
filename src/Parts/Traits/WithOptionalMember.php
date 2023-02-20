<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts\Traits;

use Exan\Fenrir\Parts\GuildMember;

/**
 * @todo phase out
 */
trait WithOptionalMember
{
    public ?GuildMember $member;
}
