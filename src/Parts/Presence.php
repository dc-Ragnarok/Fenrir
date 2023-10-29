<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

class Presence
{
    public User $user;
    public string $guild_id;
    public string $status;
    /**
     * @var Activity[]
     */
    #[ArrayMapping(Activity::class)]
    public ?array $activities;
    public ClientStatus $client_status;
}
