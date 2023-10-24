<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Attributes\Partial;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

class InviteStageInstanceObject
{
    /**
     * @var \Ragnarok\Fenrir\Parts\GuildMember[]
     */
    #[ArrayMapping(GuildMember::class)]
    public array $members;
    public int $participant_count;
    public int $speaker_count;
    public string $topic;
}
