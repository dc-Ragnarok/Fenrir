<?php

namespace Exan\Dhp\Parts;

class InteractionData
{
    public string $id;
    public string $name;
    public int $type;
    public ?InteractionDataResolved $resolved;
    /**
     * @var \Exan\Dhp\Parts\ApplicationCommandInteractionDataOptionStructure[]
     */
    public ?array $options;
    public ?string $guild_id;
    public ?string $target_id;
}
