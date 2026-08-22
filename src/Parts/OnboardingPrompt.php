<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\OnboardingPromptType;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

/**
 * @see https://discord.com/developers/docs/resources/guild#guild-onboarding-object-onboarding-prompt-structure
 */
class OnboardingPrompt
{
    public string $id;
    public OnboardingPromptType $type;
    /**
     * @var OnboardingPromptOption[]
     */
    #[ArrayMapping(OnboardingPromptOption::class)]
    public array $options;
    public string $title;
    public bool $single_select;
    public bool $required;
    public bool $in_onboarding;
}
