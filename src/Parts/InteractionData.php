<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

class InteractionData
{
    public string $id;
    public string $name;
    public int $type; // @todo enum
    public ?InteractionDataResolved $resolved;
    /**
     * @var \Ragnarok\Fenrir\Parts\ApplicationCommandInteractionDataOptionStructure[]
     */
    #[ArrayMapping(ApplicationCommandInteractionDataOptionStructure::class)]
    public ?array $options;
    public ?string $guild_id;
    public ?string $target_id;
    public ?string $custom_id;
    public ?int $component_type; // @todo enum
    /**
     * @var \Ragnarok\Fenrir\Parts\ComponentSelectOptions[]
     */
    #[ArrayMapping(ComponentSelectOptions::class)]
    public ?array $values;
}
