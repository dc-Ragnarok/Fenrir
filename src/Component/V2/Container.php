<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component\V2;

use Ragnarok\Fenrir\Component\Component;
use Ragnarok\Fenrir\Enums\MessageComponentType;
use Ragnarok\Fenrir\Exceptions\Component\TooManyItemsException;
use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentRowBuilder;

/**
 * Visually groups its children behind an optional accent colour, the components
 * v2 counterpart to an embed.
 *
 * @see https://discord.com/developers/docs/components/reference#container
 */
class Container extends Component
{
    public const MAX_COMPONENTS = 40;

    /** @var array<Component|ComponentRowBuilder> */
    private array $components = [];

    /**
     * @param ?int $accentColor RGB, as Discord sends colours elsewhere
     */
    public function __construct(
        private readonly ?int $accentColor = null,
        private readonly ?bool $spoiler = null,
        private readonly ?int $id = null
    ) {
    }

    /**
     * @throws TooManyItemsException
     */
    public function add(Component|ComponentRowBuilder $component): self
    {
        if (count($this->components) === self::MAX_COMPONENTS) {
            throw new TooManyItemsException(
                'A container can hold at most ' . self::MAX_COMPONENTS . ' components'
            );
        }

        $this->components[] = $component;

        return $this;
    }

    public function get(): array
    {
        $data = [
            'type' => MessageComponentType::CONTAINER->value,
            'components' => array_map(
                static fn (Component|ComponentRowBuilder $component) => $component instanceof ComponentRowBuilder
                    ? ['type' => MessageComponentType::ACTION_ROW->value, 'components' => $component->get()]
                    : $component->get(),
                $this->components
            ),
        ];

        if (!is_null($this->accentColor)) {
            $data['accent_color'] = $this->accentColor;
        }

        if (!is_null($this->spoiler)) {
            $data['spoiler'] = $this->spoiler;
        }

        if (!is_null($this->id)) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
