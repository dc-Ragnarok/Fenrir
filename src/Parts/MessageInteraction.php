<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Exan\Fenrir\Enums\Parts\InteractionTypes;
use Exan\Fenrir\Attributes\Partial;

class MessageInteraction
{
    public string $id;
    public InteractionTypes $type;
    public string $name;
    public User $user;
    #[Partial]
    public ?GuildMember $member;

    public function setType(int $value): void
    {
        $this->type = InteractionTypes::from($value);
    }
}
