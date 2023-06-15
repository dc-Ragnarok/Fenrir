<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

class ActiveGuildThreads
{
    /**
     * @var \Ragnarok\Fenrir\Parts\Channel[]
     */
    public array $threads;

    /**
     * @var \Ragnarok\Fenrir\Parts\ThreadMember[]
     */
    public array $members;
}
