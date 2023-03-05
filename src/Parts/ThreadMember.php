<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Carbon\Carbon;
use Exan\Fenrir\Bitwise\Bitwise;

class ThreadMember
{
    public ?string $id;
    public ?string $user_id;
    public Carbon $join_timestamp;
    public Bitwise $flags;
    public ?GuildMember $member;
}
