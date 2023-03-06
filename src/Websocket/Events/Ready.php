<?php

declare(strict_types=1);

namespace Exan\Fenrir\Websocket\Events;

use Exan\Fenrir\Attributes\Partial;
use Exan\Fenrir\Parts\Application;
use Exan\Fenrir\Parts\User;
use Exan\Fenrir\Websocket\Objects\Payload;

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
