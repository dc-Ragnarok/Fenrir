<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\ButtonStyle;
use Ragnarok\Fenrir\Enums\ChannelType;
use Ragnarok\Fenrir\Enums\MessageComponentType;
use Ragnarok\Fenrir\Enums\SeparatorSpacingSize;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

class Component
{
    public MessageComponentType $type;
    /**
     * @var Component[]
     */
    #[ArrayMapping(Component::class)]
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
    #[ArrayMapping(ComponentSelectOptions::class)]
    public ?array $options; // @todo
    /**
     * @var ChannelType[]
     */
    #[ArrayMapping(ChannelType::class)]
    public ?array $channel_types;
    public ?string $placeholder;
    public ?int $min_values;
    public ?int $max_values;
    public ?bool $required;
    public ?string $value;
    public ?string $content;
    public ?string $description;
    public ?Component $accessory;
    public ?UnfurledMediaItem $media;
    public ?UnfurledMediaItem $file;
    public ?bool $spoiler;
    /**
     * @var UnfurledMediaItem[]
     */
    #[ArrayMapping(UnfurledMediaItem::class)]
    public ?array $items;
    public ?bool $divider;
    public ?SeparatorSpacingSize $spacing;
    public ?int $accent_color;
}
