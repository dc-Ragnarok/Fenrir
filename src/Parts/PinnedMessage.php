<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Carbon\Carbon;

/**
 * @see https://discord.com/developers/docs/resources/message#message-pin-object
 */
class PinnedMessage
{
    public Carbon $pinned_at;
    public Message $message;
}
