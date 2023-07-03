<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\AutoModerationTriggerType;
use Ragnarok\Fenrir\Enums\EventType;

class AutoModerationRuleObject
{
    public string $id;
    public string $guild_id;
    public string $name;
    public string $creator_id;
    public EventType $event_type;
    public AutoModerationTriggerType $trigger_type;
    public AutoModerationTriggerMetadata $trigger_metadata;
    /**
     * @var \Ragnarok\Fenrir\Parts\AutoModerationActionStructure[]
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
        $this->event_type = EventType::from($value);
    }

    public function setTriggerType(int $value): void
    {
        $this->trigger_type = AutoModerationTriggerType::from($value);
    }
}
