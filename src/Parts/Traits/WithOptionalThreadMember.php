<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts\Traits;

use Exan\Dhp\Parts\ThreadMember;

/**
 * @todo phase out
 */
trait WithOptionalThreadMember
{
    public ?ThreadMember $member;
}
