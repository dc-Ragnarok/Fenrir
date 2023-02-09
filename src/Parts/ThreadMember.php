<?php

namespace Exan\Dhp\Parts;

use Carbon\Carbon;

class ThreadMember
{
    public ?string $id;
    public ?string $user_id;
    public Carbon $join_timestamp;
    public string $flags;
    public ?GuildMember $member;
}
