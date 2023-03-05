<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Exan\Fenrir\Attributes\Partial;

class Webhook
{
    public string $id;
    public int $type;
    public ?string $guild_id;
    public ?string $channel_id;
    public ?User $user;
    public ?string $name;
    public ?string $avatar;
    public ?string $token;
    public ?string $application_id;
    #[Partial]
    public ?Guild $source_guild;
    #[Partial]
    public ?Channel $source_channel;
    public ?string $url;
}
