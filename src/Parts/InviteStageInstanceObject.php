<?php

namespace Exan\Dhp\Parts;

class InviteStageInstanceObject
{
    /**
     * @var \Exan\Dhp\Enums\Parts\GuildMember[]
     */
    public array $members;
    public int $participant_count;
    public int $speaker_count;
    public string $topic;
}
