<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

use Ragnarok\Fenrir\Mapping\ArrayMapping;
use Ragnarok\Fenrir\Parts\SelectDefaultValue;

/**
 * @see https://docs.discord.com/developers/components/reference#role-select
 */
class RoleSelect extends Component
{
    public string $custom_id;
    public ?string $placeholder;

    /**
     * @var null|SelectDefaultValue[]
     */
    #[ArrayMapping(SelectDefaultValue::class)]
    public ?array $default_values;

    public ?int $min_values;
    public ?int $max_values;
    public ?bool $required;
    public ?bool $disabled;
}
