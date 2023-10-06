<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Enums\ExplicitContentFilterLevel;
use Ragnarok\Fenrir\Enums\GuildFeature;
use Ragnarok\Fenrir\Enums\MessageNotificationLevel;
use Ragnarok\Fenrir\Enums\MfaLevel;
use Ragnarok\Fenrir\Enums\NsfwLevel;
use Ragnarok\Fenrir\Enums\PremiumTier;
use Ragnarok\Fenrir\Enums\VerificationLevel;

class Guild
{
    public string $id;
    public string $name;
    public ?string $icon;
    public ?string $icon_hash;
    public ?string $splash;
    public ?string $discovery_splash;
    public ?bool $owner;
    public string $owner_id;
    public ?string $permissions;
    public ?string $region;
    public ?string $afk_channel_id;
    public int $afk_timeout;
    public bool $widget_enabled;
    public ?string $widget_channel_id;
    public VerificationLevel $verification_level;
    public MessageNotificationLevel $default_message_notifications;
    public ExplicitContentFilterLevel $explicit_content_filter;
    /**
     * @var \Ragnarok\Fenrir\Parts\Role[]
     */
    public array $roles;
    /**
     * @var \Ragnarok\Fenrir\Parts\Emoji[]
     */
    public array $emojis;
    /**
     * @var \Ragnarok\Fenrir\Enums\GuildFeature[]
     */
    public array $features;
    public MfaLevel $mfa_level;
    public ?string $application_id;
    public ?string $system_channel_id;
    public Bitwise $system_channel_flags;
    public ?string $rules_channel_id;
    public ?int $max_presences;
    public ?int $max_members;
    public ?string $vanity_url_code;
    public ?string $description;
    public ?string $banner;
    public PremiumTier $premium_tier;
    public ?int $premium_subscription_count;
    public string $preferred_locale;
    public ?string $public_updates_channel_id;
    public ?int $max_video_channel_users;
    public ?int $approximate_member_count;
    public ?int $approximate_presence_count;
    public ?WelcomeScreen $welcome_screen;
    public NsfwLevel $nsfw_level;
    /**
     * @var \Ragnarok\Fenrir\Parts\Sticker[]
     */
    public ?array $stickers;
    public bool $premium_progress_bar_enabled;
    public ?string $safety_alerts_channel_id;

    public function setVerificationLevel(int $value): void
    {
        $this->verification_level = VerificationLevel::tryFrom($value);
    }

    public function setDefaultMessageNotifications(int $value): void
    {
        $this->default_message_notifications = MessageNotificationLevel::tryFrom($value);
    }

    public function setExplicitContentFilter(int $value): void
    {
        $this->explicit_content_filter = ExplicitContentFilterLevel::tryFrom($value);
    }

    public function setFeatures(array $value): void
    {
        $this->features = [];

        foreach ($value as $entry) {
            $this->features[] = GuildFeature::tryFrom($entry);
        }
    }

    public function setMfaLevel(int $value): void
    {
        $this->mfa_level = MfaLevel::tryFrom($value);
    }

    public function setPremiumTier(int $value): void
    {
        $this->premium_tier = PremiumTier::tryFrom($value);
    }

    public function setNsfwLevel(int $value): void
    {
        $this->nsfw_level = NsfwLevel::tryFrom($value);
    }
}
