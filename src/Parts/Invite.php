<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Carbon\Carbon;
use Ragnarok\Fenrir\Enums\InviteTargetType;

class Invite
{
    public string $code;
    public ?Guild $guild;
    public ?Channel $channel;
    public ?User $inviter;
    public ?InviteTargetType $target_type;
    public ?User $target_user;
    public ?Application $target_application;
    public ?int $approximate_presence_count;
    public ?int $approximate_member_count;
    public ?Carbon $expires_at;
    public ?InviteStageInstanceObject $stage_instance;
    public ?GuildScheduledEvent $guild_scheduled_event;
}
