<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

class InviteStageInstanceObject
{
    /**
     * @partial
     * @var \Exan\Dhp\Parts\GuildMember[]
     */
    public array $members;
    public int $participant_count;
    public int $speaker_count;
    public string $topic;
}
