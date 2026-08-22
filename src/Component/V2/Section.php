<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component\V2;

use Ragnarok\Fenrir\Component\Button\InteractionButton;
use Ragnarok\Fenrir\Component\Button\LinkButton;
use Ragnarok\Fenrir\Component\Component;
use Ragnarok\Fenrir\Enums\MessageComponentType;
use Ragnarok\Fenrir\Exceptions\Component\TooManyItemsException;

/**
 * One to three blocks of text with a button or thumbnail alongside them.
 *
 * @see https://discord.com/developers/docs/components/reference#section
 */
class Section extends Component
{
    public const MAX_COMPONENTS = 3;

    /** @var TextDisplay[] */
    private array $components = [];

    public function __construct(
        private readonly InteractionButton|LinkButton|Thumbnail $accessory,
        private readonly ?int $id = null
    ) {
    }

    /**
     * @throws TooManyItemsException
     */
    public function add(TextDisplay $textDisplay): self
    {
        if (count($this->components) === self::MAX_COMPONENTS) {
            throw new TooManyItemsException(
                'A section can hold at most ' . self::MAX_COMPONENTS . ' text displays'
            );
        }

        $this->components[] = $textDisplay;

        return $this;
    }

    public function get(): array
    {
        $data = [
            'type' => MessageComponentType::SECTION->value,
            'components' => array_map(static fn (TextDisplay $text) => $text->get(), $this->components),
            'accessory' => $this->accessory->get(),
        ];

        if (!is_null($this->id)) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
