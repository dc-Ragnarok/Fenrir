<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

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
    public ?Guild $source_guild;
    public ?Channel $source_channel;
    public ?string $url;
}
