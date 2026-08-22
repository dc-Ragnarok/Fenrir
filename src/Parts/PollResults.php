<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

/**
 * @see https://discord.com/developers/docs/resources/poll#poll-results-object-poll-results-object-structure
 */
class PollResults
{
    public bool $is_finalized;

    /**
     * @var PollAnswerCount[]
     */
    #[ArrayMapping(PollAnswerCount::class)]
    public array $answer_counts;
}
