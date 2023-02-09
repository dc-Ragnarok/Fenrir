<?php

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\InteractionTypes;

class MessageInteraction
{
    public string $id;
    public InteractionTypes $type;
    public string $name;
    public User $user;
    public ?GuildMember $member;
}
