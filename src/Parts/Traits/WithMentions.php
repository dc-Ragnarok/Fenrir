<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts\Traits;

use Exan\Dhp\Parts\UserWithPartialMember;

trait WithMentions
{
    /**
     * @var UserWithPartialMember[]
     */
    public array $mentions;
}
