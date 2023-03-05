<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Exan\Fenrir\Attributes\Partial;

class InviteStageInstanceObject
{
    /**
     * @var \Exan\Fenrir\Parts\GuildMember[]
     */
    #[Partial]
    public array $members;
    public int $participant_count;
    public int $speaker_count;
    public string $topic;
}
