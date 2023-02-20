<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Carbon\Carbon;

class GuildMember
{
    public ?User $user;
    public ?string $nick;
    public ?string $avatar;
    /**
     * @var string[]
     */
    public array $roles;
    public Carbon $joined_at;
    public ?Carbon $premium_since;
    public bool $deaf;
    public bool $mute;
    public int $flags;
    public ?bool $pending;
    public ?string $permissions;
    public ?Carbon $communication_disabled_until;
}
