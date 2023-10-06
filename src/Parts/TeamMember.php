<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\MembershipState;

class TeamMember
{
    public MembershipState $membership_state;
    /**
     * @var string[]
     */
    public array $permissions;
    public string $team_id;
    public User $user;

    public function setMembershipState(int $value): void
    {
        $this->membership_state = MembershipState::tryFrom($value);
    }
}
