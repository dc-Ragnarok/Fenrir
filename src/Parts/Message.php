<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

/**
 * @see https://discord.com/developers/docs/resources/channel#message-object
 * @todo
 */
class Message
{
    public ?string $content;
    public string $channel_id;
}
