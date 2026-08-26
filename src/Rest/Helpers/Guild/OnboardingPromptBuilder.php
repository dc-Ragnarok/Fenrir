<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Guild;

use Ragnarok\Fenrir\Enums\OnboardingPromptType;
use Ragnarok\Fenrir\Exceptions\Component\TooManyItemsException;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://discord.com/developers/docs/resources/guild#guild-onboarding-object-onboarding-prompt-structure
 */
class OnboardingPromptBuilder
{
    use GetNew;

    public const MAX_OPTIONS = 50;

    private array $data = [];

    /** @var OnboardingPromptOptionBuilder[] */
    private array $options = [];

    /**
     * Discord requires an id on every prompt, including new ones, and accepts
     * any placeholder for prompts that do not exist yet.
     */
    public function setId(string $id): self
    {
        $this->data['id'] = $id;

        return $this;
    }

    public function getId(): ?string
    {
        return $this->data['id'] ?? null;
    }

    public function setTitle(string $title): self
    {
        $this->data['title'] = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->data['title'] ?? null;
    }

    public function setType(OnboardingPromptType $type): self
    {
        $this->data['type'] = $type->value;

        return $this;
    }

    public function setSingleSelect(bool $singleSelect): self
    {
        $this->data['single_select'] = $singleSelect;

        return $this;
    }

    public function setRequired(bool $required): self
    {
        $this->data['required'] = $required;

        return $this;
    }

    /**
     * Whether the prompt appears during onboarding itself, as opposed to only
     * in the server guide afterwards.
     */
    public function setInOnboarding(bool $inOnboarding): self
    {
        $this->data['in_onboarding'] = $inOnboarding;

        return $this;
    }

    /**
     * @throws TooManyItemsException
     */
    public function addOption(OnboardingPromptOptionBuilder $option): self
    {
        if (count($this->options) === self::MAX_OPTIONS) {
            throw new TooManyItemsException(
                'An onboarding prompt can hold at most ' . self::MAX_OPTIONS . ' options'
            );
        }

        $this->options[] = $option;

        return $this;
    }

    /** @return OnboardingPromptOptionBuilder[] */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function get(): array
    {
        return [
            ...$this->data,
            'options' => array_map(
                static fn (OnboardingPromptOptionBuilder $option) => $option->get(),
                $this->options
            ),
        ];
    }
}
