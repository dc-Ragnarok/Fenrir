<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\ButtonStyle;
use Ragnarok\Fenrir\Enums\ChannelTypes;
use Ragnarok\Fenrir\Enums\MessageComponentType;

class Component
{
    public MessageComponentType $type;
    /**
     * @var \Ragnarok\Fenrir\Parts\Component[]
     */
    public ?array $components;
    public ?ButtonStyle $style;
    public ?string $label;
    public ?Emoji $emoji;
    public ?string $custom_id;
    public ?string $url;
    public ?bool $disabled;
    /**
     * @var \Ragnarok\Fenrir\Parts\ComponentSelectOptions[]
     */
    public ?array $options; // @todo
    /**
     * @var \Ragnarok\Fenrir\Enums\ChannelTypes[]
     */
    public ?array $channel_types;
    public ?string $placeholder;
    public ?int $min_values;
    public ?int $max_values;
    public ?bool $required;
    public ?string $value;

    public function setChannelTypes(array $values): void
    {
        $this->channel_types = [];

        foreach ($values as $entry) {
            $this->channel_types[] = ChannelTypes::from($entry);
        }
    }

    public function setType(int $value): void
    {
        $this->type = MessageComponentType::from($value);
    }

    public function setStyle(int $value): void
    {
        $this->style = ButtonStyle::from($value);
    }
}
