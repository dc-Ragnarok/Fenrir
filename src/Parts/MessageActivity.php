<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\MessageActivityTypes;

class MessageActivity
{
    public MessageActivityTypes $type;
    public ?string $party_id;

    public function setType(int $value): void
    {
        $this->type = MessageActivityTypes::from($value);
    }
}
