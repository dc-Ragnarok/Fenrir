<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

use Ragnarok\Fenrir\Mapping\ArrayMapping;
use Ragnarok\Fenrir\Parts\ComponentSelectOptions;

/**
 * @see https://docs.discord.com/developers/components/reference#string-select
 */
class StringSelect extends Component
{
    public string $custom_id;

    /**
     * @var ComponentSelectOptions[]
     */
    #[ArrayMapping(ComponentSelectOptions::class)]
    public array $options;

    public ?string $placeholder;
    public ?int $min_values;
    public ?int $max_values;
    public ?bool $required;
    public ?bool $disabled;
}
