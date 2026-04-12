<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

use Ragnarok\Fenrir\Enums\ChannelType;
use Ragnarok\Fenrir\Mapping\ArrayMapping;
use Ragnarok\Fenrir\Parts\SelectDefaultValue;

/**
 * @see https://docs.discord.com/developers/components/reference#channel-select
 */
class ChannelSelect extends Component
{
    public ?string $custom_id;

    /**
     * @var null|ChannelType[]
     */
    #[ArrayMapping(ChannelType::class)]
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
