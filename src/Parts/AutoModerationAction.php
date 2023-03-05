<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Exan\Fenrir\Enums\Parts\ActionTypes;

/**
 * @see https://discord.com/developers/docs/resources/auto-moderation#auto-moderation-action-object
 */
class AutoModerationAction
{
    public ActionTypes $type;
    public ?AutoModerationActionMetadata $metadata;
}
