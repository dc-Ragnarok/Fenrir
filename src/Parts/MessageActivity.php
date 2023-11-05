<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\MessageActivityType;

class MessageActivity
{
    public MessageActivityType $type;
    public ?string $party_id;
}
