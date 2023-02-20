<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

class Team
{
    public ?string $icon;
    public string $id;
    /**
     * @var \Exan\Finrir\Parts\TeamMember[]
     */
    public array $members;
    public string $name;
    public string $owner_user_id;
}
