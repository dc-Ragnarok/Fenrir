<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

/**
 * @see https://discord.com/developers/docs/resources/poll#poll-answer-object-poll-answer-object-structure
 */
class PollAnswer
{
    public int $answer_id;
    public PollMediaObject $poll_media;
}
