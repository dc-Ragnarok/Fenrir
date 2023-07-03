<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Carbon\Carbon;
use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-member-update
 */
#[RequiresIntent(Intent::GUILD_MEMBERS)]
class GuildMemberUpdate
{
    public string $guild_id;

    /**
     * @var string[]
     */
    public array $roles;

    public User $user;
    public ?string $nick;
    public ?string $avatar;
    public ?Carbon $joined_at;
    public ?Carbon $premium_since;
    public ?bool $deaf;
    public ?bool $mute;
    public ?bool $pending;
    public ?Carbon $communication_disabled_until;
}
