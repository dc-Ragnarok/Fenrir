<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

/**
 * @see https://discord.com/developers/docs/resources/guild#guild-onboarding-object-prompt-option-structure
 */
class OnboardingPromptOption
{
    public string $id;
    public string $title;
    public ?string $description;
    public Emoji $emoji;
    /** @var string[] */
    public array $role_ids;
    /** @var string[] */
    public array $channel_ids;
}
