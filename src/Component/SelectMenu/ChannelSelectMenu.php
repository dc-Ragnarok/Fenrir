<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component\SelectMenu;

use Ragnarok\Fenrir\Enums\Component\SelectMenuType;

class ChannelSelectMenu extends SelectMenu
{
    protected SelectMenuType $type = SelectMenuType::Channel;

    /**
     * @var string[] $items
     */
    public function __construct(
        protected string $customId,
        protected ?string $placeholder = null,
        protected ?array $channelTypes = null,
        protected ?int $minValues = null,
        protected ?int $maxValues = null,
        protected bool $disabled = false
    ) {
        parent::__construct(
            $customId,
            $placeholder,
            $minValues,
            $maxValues,
            $disabled
        );
    }

    public function get(): array
    {
        return array_merge(
            parent::get(),
            is_null($this->channelTypes) ? [] : ['channel_types' => $this->channelTypes]
        );
    }
}
