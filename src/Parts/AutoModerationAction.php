<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\ActionType;
use Exan\Dhp\Enums\Parts\AutoModeractionActionMetadata;

/**
 * @see https://discord.com/developers/docs/resources/auto-moderation#auto-moderation-action-object
 * @todo
 */
class AutoModeractionAction
{
    public ActionType $type;
    public ?AutoModeractionActionMetadata $metadata;
}
