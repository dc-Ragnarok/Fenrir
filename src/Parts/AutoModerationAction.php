<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\ActionTypes;
use Exan\Dhp\Enums\Parts\AutoModeractionActionMetadata;

/**
 * @see https://discord.com/developers/docs/resources/auto-moderation#auto-moderation-action-object
 */
class AutoModeractionAction
{
    public ActionTypes $type;
    public ?AutoModeractionActionMetadata $metadata;
}
