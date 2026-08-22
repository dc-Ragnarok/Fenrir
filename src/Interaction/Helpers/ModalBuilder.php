<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Interaction\Helpers;

use Ragnarok\Fenrir\Component\Component;
use Ragnarok\Fenrir\Exceptions\Component\TooManyItemsException;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * A modal to show in response to an interaction.
 *
 * Interactive components go inside a Label, which carries the text shown above
 * the input. The custom id set here is the one that comes back on the
 * ModalSubmitInteraction, separate from the custom ids of the inputs within.
 *
 * @see https://discord.com/developers/docs/interactions/receiving-and-responding#modal
 */
class ModalBuilder
{
    use GetNew;

    public const MAX_COMPONENTS = 40;

    /** @var Component[] */
    private array $components = [];

    private string $customId;

    private string $title;

    public function setCustomId(string $customId): self
    {
        $this->customId = $customId;

        return $this;
    }

    public function getCustomId(): ?string
    {
        return $this->customId ?? null;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title ?? null;
    }

    /**
     * @throws TooManyItemsException
     */
    public function add(Component $component): self
    {
        if (count($this->components) === self::MAX_COMPONENTS) {
            throw new TooManyItemsException(
                'A modal can hold at most ' . self::MAX_COMPONENTS . ' components'
            );
        }

        $this->components[] = $component;

        return $this;
    }

    /**
     * @return Component[]
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    public function get(): array
    {
        return [
            'custom_id' => $this->customId,
            'title' => $this->title,
            'components' => array_map(
                static fn (Component $component) => $component->get(),
                $this->components
            ),
        ];
    }
}
