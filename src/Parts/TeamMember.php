<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\Parts\MembershipStates;
use Ragnarok\Fenrir\Attributes\Partial;

class TeamMember
{
    public MembershipStates $membership_state;
    /**
     * @var string[]
     */
    public array $permissions;
    public string $team_id;
    #[Partial]
    public User $user;

    public function setMembershipState(int $value): void
    {
        $this->membership_state = MembershipStates::from($value);
    }
}
