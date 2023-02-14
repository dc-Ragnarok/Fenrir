<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\InviteTargetTypes;
use Carbon\Carbon;

class Invite
{
    public string $code;
    public ?Guild $guild;
    public ?Channel $channel;
    public ?User $inviter;
    public ?InviteTargetTypes $target_type;
    public ?User $target_user;
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
