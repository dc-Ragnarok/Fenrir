<?php

namespace Exan\Dhp\Parts;


class Team
{
    public ?string $icon;
    public string $id;
    /** @var \Exan\Dhp\Parts\TeamMember[] */
    public array $members;
    public string $name;
    public string $owner_user_id;
}
