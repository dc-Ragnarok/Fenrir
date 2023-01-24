<?php

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\ActionType;
use Exan\Dhp\Enums\Parts\AutoModeractionActionMetadata;

class AutoModeractionAction
{
    public ActionType $type;
    public ?AutoModeractionActionMetadata $metadata;
}
