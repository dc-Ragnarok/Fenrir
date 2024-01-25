<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

class GuildScheduledEventUser
{
    public string $guild_scheduled_event_id;
    public User $user;
    public ?GuildMember $member;
}
