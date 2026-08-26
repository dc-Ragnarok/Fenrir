<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Guild;

use Ragnarok\Fenrir\Enums\GuildOnboardingMode;
use Ragnarok\Fenrir\Exceptions\Component\TooManyItemsException;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://discord.com/developers/docs/resources/guild#modify-guild-onboarding
 */
class ModifyGuildOnboardingBuilder
{
    use GetNew;

    public const MAX_PROMPTS = 15;

    private array $data = [];

    /** @var OnboardingPromptBuilder[] */
    private array $prompts = [];

    /**
     * @throws TooManyItemsException
     */
    public function addPrompt(OnboardingPromptBuilder $prompt): self
    {
        if (count($this->prompts) === self::MAX_PROMPTS) {
            throw new TooManyItemsException(
                'Onboarding can hold at most ' . self::MAX_PROMPTS . ' prompts'
            );
        }

        $this->prompts[] = $prompt;

        return $this;
    }

    /** @return OnboardingPromptBuilder[] */
    public function getPrompts(): array
    {
        return $this->prompts;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->data['enabled'] = $enabled;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->data['enabled'] ?? null;
    }

    /**
     * @param string[] $channelIds Channels every member is opted into
     */
    public function setDefaultChannelIds(array $channelIds): self
    {
        $this->data['default_channel_ids'] = array_values($channelIds);

        return $this;
    }

    /** @return ?string[] */
    public function getDefaultChannelIds(): ?array
    {
        return $this->data['default_channel_ids'] ?? null;
    }

    public function setMode(GuildOnboardingMode $mode): self
    {
        $this->data['mode'] = $mode->value;

        return $this;
    }

    public function get(): array
    {
        $data = $this->data;

        if ($this->prompts !== []) {
            $data['prompts'] = array_map(
                static fn (OnboardingPromptBuilder $prompt) => $prompt->get(),
                $this->prompts
            );
        }

        return $data;
    }
}
