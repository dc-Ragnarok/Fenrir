<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

/**
 * Whether onboarding counts only default channels towards its requirements, or
 * the channels reachable through prompts as well.
 *
 * @see https://discord.com/developers/docs/resources/guild#guild-onboarding-object-onboarding-mode
 */
enum GuildOnboardingMode: int
{
    case ONBOARDING_DEFAULT = 0;
    case ONBOARDING_ADVANCED = 1;
}
