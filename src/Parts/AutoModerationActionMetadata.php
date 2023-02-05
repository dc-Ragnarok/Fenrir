<?php

declare(strict_types=1);

namespace Exan\Dhp\Enums\Parts;

/**
 * @see https://discord.com/developers/docs/resources/auto-moderation#auto-moderation-action-object-action-metadata
 */
class AutoModeractionActionMetadata
{
    public string $channel_id;
    public int $duration_seconds;
}
