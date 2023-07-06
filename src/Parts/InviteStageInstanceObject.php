<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Attributes\Partial;

class InviteStageInstanceObject
{
    /**
     * @var \Ragnarok\Fenrir\Parts\GuildMember[]
     */
    public array $members;
    public int $participant_count;
    public int $speaker_count;
    public string $topic;
}
