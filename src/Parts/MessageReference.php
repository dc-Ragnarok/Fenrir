<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\MessageReferenceType;

class MessageReference
{
    public ?MessageReferenceType $type;
    public ?string $message_id;
    public ?string $channel_id;
    public ?string $guild_id;
    public ?bool $fail_if_not_exists;
}
