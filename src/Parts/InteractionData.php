<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\MessageComponentType;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

class InteractionData
{
    public string $id;
    public string $name;
    public int $type; // @todo enum
    public ?InteractionDataResolved $resolved;
    /**
     * @var ApplicationCommandInteractionDataOptionStructure[]
     */
    #[ArrayMapping(ApplicationCommandInteractionDataOptionStructure::class)]
    public ?array $options;
    public ?string $guild_id;
    public ?string $target_id;
    public ?string $custom_id;
    public ?MessageComponentType $component_type;
    /**
     * The values a user picked in a select menu. Discord sends these as plain
     * strings: the option values for a string select, and ids for the user,
     * role, mentionable and channel selects.
     *
     * @var ?string[]
     */
    public ?array $values;
    /**
     * What a user submitted in a modal. The shape is nested and differs between
     * classic action row modals and label based ones, so it is left as the raw
     * payload; ModalSubmitInteraction reads it.
     */
    public ?array $components;
}
