<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Ragnarok\Fenrir\Gateway\Objects\Payload;
use Ragnarok\Fenrir\Parts\Application;
use Ragnarok\Fenrir\Parts\User;

class Ready extends Payload
{
    public int $v;
    public User $user;

    /** @var \Ragnarok\Fenrir\Parts\UnavailableGuild[] */
    public array $guilds;

    public string $session_id;
    public string $resume_gateway_url;
    public array $shard;
    public Application $application;
}
