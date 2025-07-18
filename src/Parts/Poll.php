<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Carbon\Carbon;
use Ragnarok\Fenrir\Enums\PollLayoutType;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

/**
 * @see https://discord.com/developers/docs/resources/poll#poll-object
 */
class Poll
{
    public PollMediaObject $question;

    /**
     * @var PollAnswer[]
     */
    #[ArrayMapping(PollAnswer::class)]
    public array $answers;
    public Carbon $expiry;
    public bool $allow_multiselect;
    public PollLayoutType $layout_type;
}
