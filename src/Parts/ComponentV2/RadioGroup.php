<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

/**
 * @see https://docs.discord.com/developers/components/reference#radio-group
 */
class RadioGroup extends Component
{
    public string $custom_id;

    /**
     * @var RadioGroupOption[]
     */
    #[ArrayMapping(RadioGroupOption::class)]
    public array $options;

    public ?bool $required;
}
