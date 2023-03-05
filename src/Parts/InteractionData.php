<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

class InteractionData
{
    public string $id;
    public string $name;
    public int $type;
    public ?InteractionDataResolved $resolved;
    /**
     * @var \Ragnarok\Fenrir\Parts\ApplicationCommandInteractionDataOptionStructure[]
     */
    public ?array $options;
    public ?string $guild_id;
    public ?string $target_id;
}
