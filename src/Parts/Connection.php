<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\ConnectionService;
use Ragnarok\Fenrir\Enums\ConnectionVisibility;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

class Connection
{
    public string $id;
    public string $name;
    public ConnectionService $type;

    /**
     * @var Integration[]
     */
    #[ArrayMapping(Integration::class)]
    public array $integrations;

    public bool $verified;
    public bool $friend_sync;
    public bool $show_activity;
    public bool $two_way_link;
    public ConnectionVisibility $visibility;
}
