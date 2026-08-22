<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\GuildOnboardingMode;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

/**
 * @see https://discord.com/developers/docs/resources/guild#guild-onboarding-object
 */
class GuildOnboarding
{
    public string $guild_id;
    /**
     * @var OnboardingPrompt[]
     */
    #[ArrayMapping(OnboardingPrompt::class)]
    public array $prompts;
    /** @var string[] */
    public array $default_channel_ids;
    public bool $enabled;
    public GuildOnboardingMode $mode;
}
