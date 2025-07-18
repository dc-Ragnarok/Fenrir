<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

/**
 * @see https://discord.com/developers/docs/resources/message#message-snapshot-object
 */
class MessageSnapshot
{
    public Message $message;
}
