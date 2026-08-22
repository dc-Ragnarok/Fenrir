<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

/**
 * @see https://discord.com/developers/docs/resources/guild#guild-onboarding-object-prompt-types
 */
enum OnboardingPromptType: int
{
    case MULTIPLE_CHOICE = 0;
    case DROPDOWN = 1;
}
