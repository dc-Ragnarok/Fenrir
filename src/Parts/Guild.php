<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\VerificationLevels;
use Exan\Dhp\Enums\Parts\MessageNotificationLevels;
use Exan\Dhp\Enums\Parts\ExplicitContentFilterLevels;
use Exan\Dhp\Enums\Parts\GuildFeatures;
use Exan\Dhp\Enums\Parts\MfaLevels;
use Exan\Dhp\Bitwise\Bitwise;
use Exan\Dhp\Enums\Parts\PremiumTiers;
use Exan\Dhp\Enums\Parts\NsfwLevels;

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
    public VerificationLevels $verification_level;
    public MessageNotificationLevels $default_message_notifications;
    public ExplicitContentFilterLevels $explicit_content_filter;
    /**
     * @var \Exan\Dhp\Parts\Role[]
     */
    public array $roles;
    /**
     * @var \Exan\Dhp\Parts\Emoji[]
     */
    public array $emojis;
    /**
     * @var \Exan\Dhp\Enums\Parts\GuildFeatures[]
     */
    public array $features;
    public MfaLevels $mfa_level;
    public ?string $application_id;
    public ?string $system_channel_id;
    public Bitwise $system_channel_flags;
    public ?string $rules_channel_id;
    public ?int $max_presences;
    public ?int $max_members;
    public ?string $vanity_url_code;
    public ?string $description;
    public ?string $banner;
    public PremiumTiers $premium_tier;
    public ?int $premium_subscription_count;
    public string $preferred_locale;
    public ?string $public_updates_channel_id;
    public ?int $max_video_channel_users;
    public ?int $approximate_member_count;
    public ?int $approximate_presence_count;
    public ?WelcomeScreen $welcome_screen;
    public NsfwLevels $nsfw_level;
    /**
     * @var \Exan\Dhp\Parts\Sticker[]
     */
    public ?array $stickers;
    public bool $premium_progress_bar_enabled;

    public function setVerificationLevel(int $value): void
    {
        $this->verification_level = VerificationLevels::from($value);
    }

    public function setDefaultMessageNotifications(int $value): void
    {
        $this->default_message_notifications = MessageNotificationLevels::from($value);
    }

    public function setExplicitContentFilter(int $value): void
    {
        $this->explicit_content_filter = ExplicitContentFilterLevels::from($value);
    }

    public function setFeatures(array $value): void
    {
        $this->features = [];

        foreach ($value as $entry) {
            $this->features[] = GuildFeatures::from($entry);
        }
    }

    public function setMfaLevel(int $value): void
    {
        $this->mfa_level = MfaLevels::from($value);
    }

    public function setPremiumTier(int $value): void
    {
        $this->premium_tier = PremiumTiers::from($value);
    }

    public function setNsfwLevel(int $value): void
    {
        $this->nsfw_level = NsfwLevels::from($value);
    }
}
