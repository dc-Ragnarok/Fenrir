<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

use Ragnarok\Fenrir\Mapping\ArrayMapping;
use Ragnarok\Fenrir\Parts\CheckboxGroupOption;

/**
 * @see https://docs.discord.com/developers/components/reference#checkbox-group
 */
class CheckboxGroup extends Component
{
    public string $custom_id;

    /**
     * @var CheckboxGroupOption[]
     */
    #[ArrayMapping(CheckboxGroupOption::class)]
    public array $options;

    public ?int $min_values;
    public ?int $max_values;
    public ?bool $required;
}
