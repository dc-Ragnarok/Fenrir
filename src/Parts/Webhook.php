<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

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
    /**
     * @partial
     */
    public ?Guild $source_guild;
    /**
     * @partial
     */
    public ?Channel $source_channel;
    public ?string $url;
}
