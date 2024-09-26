<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\InteractionType;

class MessageInteractionMetadata
{
    public string $id;
    public InteractionType $type;
    public string $name;
    public User $user;
    public ?GuildMember $member;
}
