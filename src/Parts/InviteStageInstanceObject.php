<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

use Exan\Finrir\Attributes\Partial;

class InviteStageInstanceObject
{
    /**
     * @var \Exan\Finrir\Parts\GuildMember[]
     */
    #[Partial]
    public array $members;
    public int $participant_count;
    public int $speaker_count;
    public string $topic;
}
