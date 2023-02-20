<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

use Exan\Finrir\Enums\Parts\InteractionTypes;
use Exan\Finrir\Attributes\Partial;

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
