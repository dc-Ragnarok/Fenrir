<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

class Team
{
    public ?string $icon;
    public string $id;
    /**
     * @var TeamMember[]
     */
    public array $members;
    public string $name;
    public string $owner_user_id;
}
