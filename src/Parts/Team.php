<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

class Team
{
    public ?string $icon;
    public string $id;
    /**
     * @var \Ragnarok\Fenrir\Parts\TeamMember[]
     */
    #[ArrayMapping(TeamMember::class)]
    public array $members;
    public string $name;
    public string $owner_user_id;
}
