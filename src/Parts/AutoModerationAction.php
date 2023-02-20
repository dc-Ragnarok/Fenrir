<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

use Exan\Finrir\Enums\Parts\ActionTypes;
use Exan\Finrir\Enums\Parts\AutoModeractionActionMetadata;

/**
 * @see https://discord.com/developers/docs/resources/auto-moderation#auto-moderation-action-object
 */
class AutoModeractionAction
{
    public ActionTypes $type;
    public ?AutoModeractionActionMetadata $metadata;
}
