<?php

namespace Exan\Dhp\Parts;

class MessageReference
{
    public ?string $message_id;
    public ?string $channel_id;
    public ?string $guild_id;
    public ?bool $fail_if_not_exists;
}
