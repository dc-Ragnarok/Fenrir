<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

use Exan\Dhp\Attributes\Partial;

class InviteStageInstanceObject
{
    /**
     * @var \Exan\Dhp\Parts\GuildMember[]
     */
    #[Partial]
    public array $members;
    public int $participant_count;
    public int $speaker_count;
    public string $topic;
}
