<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

/**
 * @see https://discord.com/developers/docs/resources/channel#search-threads
 */
class ThreadSearchResult
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
    /**
     * The first message of each thread, when Discord includes them.
     *
     * @var Message[]
     */
    #[ArrayMapping(Message::class)]
    public array $first_messages;
    public bool $has_more;
    public int $total_results;
}
