<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Exan\Fenrir\Enums\Parts\InviteTargetTypes;
use Carbon\Carbon;
use Exan\Fenrir\Attributes\Partial;

class Invite
{
    public string $code;
    #[Partial]
    public ?Guild $guild;
    #[Partial]
    public ?Channel $channel;
    public ?User $inviter;
    public ?InviteTargetTypes $target_type;
    public ?User $target_user;
    #[Partial]
    public ?Application $target_application;
    public ?int $approximate_presence_count;
    public ?int $approximate_member_count;
    public ?Carbon $expires_at;
    public ?InviteStageInstanceObject $stage_instance;
    public ?GuildScheduledEvent $guild_scheduled_event;

    public function setTargetType(int $value): void
    {
        $this->target_type = InviteTargetTypes::from($value);
    }
}
