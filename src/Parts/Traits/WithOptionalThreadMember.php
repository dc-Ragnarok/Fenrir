<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts\Traits;

use Exan\Fenrir\Parts\ThreadMember;

/**
 * @todo phase out
 */
trait WithOptionalThreadMember
{
    public ?ThreadMember $member;
}
