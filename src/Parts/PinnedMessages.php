<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

/**
 * A page of pinned messages, newest first.
 *
 * @see https://discord.com/developers/docs/resources/message#get-channel-pins
 */
class PinnedMessages
{
    /**
     * @var PinnedMessage[]
     */
    #[ArrayMapping(PinnedMessage::class)]
    public array $items;
    public bool $has_more;
}
