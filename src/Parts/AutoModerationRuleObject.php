<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\EventTypes;
use Exan\Dhp\Enums\Parts\AutoModerationTriggerTypes;

class AutoModerationRuleObject
{
    public string $id;
    public string $guild_id;
    public string $name;
    public string $creator_id;
    public EventTypes $event_type;
    public AutoModerationTriggerTypes $trigger_type;
    public AutoModerationTriggerMetadata $trigger_metadata;
    /**
     * @var \Exan\Dhp\Parts\AutoModerationActionStructure[]
     */
    public array $actions;
    public bool $enabled;
    /**
     * @var string[]
     */
    public array $exempt_roles;
    /**
     * @var string[]
     */
    public array $exempt_channels;

    public function setEventType(int $value): void
    {
        $this->event_type = EventTypes::from($value);
    }

    public function setTriggerType(int $value): void
    {
        $this->trigger_type = AutoModerationTriggerTypes::from($value);
    }
}
