<?php

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\MessageActivityTypes;

class MessageActivity
{
    public MessageActivityTypes $type;
    public ?string $party_id;
}
