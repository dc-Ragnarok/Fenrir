<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Carbon\Carbon;
use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Enums\Parts\TargetType;
use Ragnarok\Fenrir\Parts\Application;
use Ragnarok\Fenrir\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#invite-create
 */
#[RequiresIntent(Intent::GUILD_INVITES)]
class InviteCreate
{
    public string $channel_id;
    public string $code;
    public Carbon $created_at;
    public ?string $guild_id;
    public ?User $inviter;
    public int $max_age;
    public int $max_uses;
    public TargetType $target_type;
    public ?User $target_user;
    public ?Application $target_application;
    public bool $temporary;
    public bool $uses;
}
