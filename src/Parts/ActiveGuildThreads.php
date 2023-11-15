<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

class ActiveGuildThreads
{
    /**
     * @var Channel[]
     */
    #[ArrayMapping(Channel::class)]
    public array $threads;

    /**
     * @var ThreadMember[]
     */
    #[ArrayMapping(ThreadMember::class)]
    public array $members;
}
