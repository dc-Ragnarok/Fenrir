<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component\Modal;

use Ragnarok\Fenrir\Component\Component;
use Ragnarok\Fenrir\Enums\MessageComponentType;
use Ragnarok\Fenrir\Exceptions\Component\TooManyItemsException;

/**
 * Several checkboxes the user can tick independently.
 *
 * @see https://discord.com/developers/docs/components/reference#checkbox-group
 */
class CheckboxGroup extends Component
{
    public const MAX_OPTIONS = 10;

    /** @var Option[] */
    private array $options = [];

    public function __construct(
        private readonly string $customId,
        private readonly ?int $minValues = null,
        private readonly ?int $maxValues = null,
        private readonly ?bool $required = null,
        private readonly ?int $id = null
    ) {
    }

    /**
     * @throws TooManyItemsException
     */
    public function add(Option $option): self
    {
        if (count($this->options) === self::MAX_OPTIONS) {
            throw new TooManyItemsException(
                'A checkbox group can hold at most ' . self::MAX_OPTIONS . ' options'
            );
        }

        $this->options[] = $option;

        return $this;
    }

    public function get(): array
    {
        $data = [
            'type' => MessageComponentType::CHECKBOX_GROUP->value,
            'custom_id' => $this->customId,
            'options' => array_map(static fn (Option $option) => $option->get(), $this->options),
        ];

        if (!is_null($this->minValues)) {
            $data['min_values'] = $this->minValues;
        }

        if (!is_null($this->maxValues)) {
            $data['max_values'] = $this->maxValues;
        }

        if (!is_null($this->required)) {
            $data['required'] = $this->required;
        }

        if (!is_null($this->id)) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
