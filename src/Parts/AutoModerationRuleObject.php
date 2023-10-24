<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\AutoModerationRuleTriggerType;
use Ragnarok\Fenrir\Enums\AutoModerationRuleEventType;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

class AutoModerationRuleObject
{
    public string $id;
    public string $guild_id;
    public string $name;
    public string $creator_id;
    public AutoModerationRuleEventType $event_type;
    public AutoModerationRuleTriggerType $trigger_type;
    public AutoModerationTriggerMetadata $trigger_metadata;
    /**
     * @var \Ragnarok\Fenrir\Parts\AutoModerationActionStructure[]
     */
    #[ArrayMapping(AutoModerationActionStructure::class)]
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
        $this->event_type = AutoModerationRuleEventType::tryFrom($value);
    }

    public function setTriggerType(int $value): void
    {
        $this->trigger_type = AutoModerationRuleTriggerType::tryFrom($value);
    }
}
