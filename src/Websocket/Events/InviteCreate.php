<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Carbon\Carbon;
use Exan\Fenrir\Enums\Parts\TargetType;
use Exan\Fenrir\Parts\Application;
use Exan\Fenrir\Parts\User;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#invite-create
 */
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
