<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

class GuildBan
{
    public ?string $reason;
    public User $user;
}
