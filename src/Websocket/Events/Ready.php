<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Websocket\Events;

use Ragnarok\Fenrir\Attributes\Partial;
use Ragnarok\Fenrir\Parts\Application;
use Ragnarok\Fenrir\Parts\User;
use Ragnarok\Fenrir\Websocket\Objects\Payload;

class Ready extends Payload
{
    public int $v;
    public User $user;
    public string $session_id;
    public string $resume_gateway_url;
    public array $shard;

    #[Partial]
    public Application $application;
}
