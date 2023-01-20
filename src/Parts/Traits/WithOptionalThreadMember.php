<?php

declare(strict_types=1);

use Exan\Dhp\Parts\ThreadMember;

trait WithOptionalThreadMember
{
    public ?ThreadMember $member;
}
