<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

class Team
{
    public ?string $icon;
    public string $id;
    /**
     * @var \Exan\Fenrir\Parts\TeamMember[]
     */
    public array $members;
    public string $name;
    public string $owner_user_id;
}
