<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

class ActiveGuildThreads
{
    /**
     * @var \Ragnarok\Fenrir\Parts\Channel[]
     */
    #[ArrayMapping(Channel::class)]
    public array $threads;

    /**
     * @var \Ragnarok\Fenrir\Parts\ThreadMember[]
     */
    #[ArrayMapping(ThreadMember::class)]
    public array $members;
}
