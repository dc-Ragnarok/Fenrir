<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\Component\ButtonStyle;
use Ragnarok\Fenrir\Enums\Parts\ChannelTypes;
use Ragnarok\Fenrir\Enums\Parts\MessageComponentTypes;
use Ragnarok\Fenrir\Parts\Emoji;

class Component
{
    public MessageComponentTypes $type;
    /**
     * @var Component[]
     */
    public ?array $components;
    public ?ButtonStyle $style;
    public ?string $label;
    public ?Emoji $emoji;
    public ?string $custom_id;
    public ?string $url;
    public ?bool $disabled;
    /**
     * @var ComponentSelectOptions[]
     */
    public ?array $options; // @todo
    /**
     * @var ChannelTypes[]
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
        $this->type = MessageComponentTypes::from($value);
    }

    public function setStyle(int $value): void
    {
        $this->style = ButtonStyle::from($value);
    }
}
