<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Attributes\Partial;
use Ragnarok\Fenrir\Enums\InteractionType;

class MessageInteraction
{
    public string $id;
    public InteractionType $type;
    public string $name;
    public User $user;
    public ?GuildMember $member;
}
