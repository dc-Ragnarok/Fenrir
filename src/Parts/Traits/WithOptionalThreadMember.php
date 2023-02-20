<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts\Traits;

use Exan\Finrir\Parts\ThreadMember;

/**
 * @todo phase out
 */
trait WithOptionalThreadMember
{
    public ?ThreadMember $member;
}
