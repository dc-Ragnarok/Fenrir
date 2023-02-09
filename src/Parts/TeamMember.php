<?php

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\MembershipStates;

class TeamMember
{
    public MembershipStates $membership_state;
    /** @var \Exan\Dhp\Parts\string[] */
    public array $permissions;
    public string $team_id;
    public User $user;
}
