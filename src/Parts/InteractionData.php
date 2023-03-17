<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

class InteractionData
{
    public string $id;
    public string $name;
    public int $type; // @todo enum
    public ?InteractionDataResolved $resolved;
    /**
     * @var \Exan\Fenrir\Parts\ApplicationCommandInteractionDataOptionStructure[]
     */
    public ?array $options;
    public ?string $guild_id;
    public ?string $target_id;
    public ?string $custom_id;
    public ?int $component_type; // @todo enum
    /**
     * @var \Exan\Fenrir\Parts\ComponentSelectOptions[]
     */
    public ?array $values;
}
