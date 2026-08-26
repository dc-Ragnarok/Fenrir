<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

/**
 * @see https://discord.com/developers/docs/resources/poll#get-answer-voters
 */
class PollAnswerVoters
{
    /**
     * @var User[]
     */
    #[ArrayMapping(User::class)]
    public array $users;
}
