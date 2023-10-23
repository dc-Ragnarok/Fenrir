<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Carbon\Carbon;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Enums\ChannelType;
use Ragnarok\Fenrir\Enums\ForumLayoutType;
use Ragnarok\Fenrir\Enums\SortOrderType;
use Ragnarok\Fenrir\Enums\VideoQualityMode;

class Channel
{
    public string $id;
    public ChannelType $type;
    public ?string $guild_id;
    public ?int $position;
    /**
     * @var \Ragnarok\Fenrir\Parts\Overwrite[]
     */
    public ?array $permission_overwrites;
    public ?string $name;
    public ?string $topic;
    public ?bool $nsfw;
    public ?string $last_message_id;
    public ?int $bitrate;
    public ?int $user_limit;
    public ?int $rate_limit_per_user;
    /**
     * @var \Ragnarok\Fenrir\Parts\User[]
     */
    public ?array $recipients;
    public ?string $icon;
    public ?string $owner_id;
    public ?string $application_id;
    public ?string $parent_id;
    public ?Carbon $last_pin_timestamp;
    public ?string $rtc_region;
    public ?VideoQualityMode $video_quality_mode;
    public ?int $message_count;
    public ?int $member_count;
    public ?ThreadMetadata $thread_metadata;
    public ?ThreadMember $member;
    public ?int $default_auto_archive_duration;
    public ?string $permissions;
    public ?Bitwise $flags;
    public ?int $total_message_sent;
    /**
     * @var \Ragnarok\Fenrir\Parts\Tag[]
     */
    public ?array $available_tags;
    /**
     * @var string[]
     */
    public ?array $applied_tags;
    public ?DefaultReaction $default_reaction_emoji;
    public ?int $default_thread_rate_limit_per_user;
    public ?SortOrderType $default_sort_order;
    public ?ForumLayoutType $default_forum_layout;

    public function setType(int $value): void
    {
        $this->type = ChannelType::tryFrom($value);
    }

    public function setVideoQualityMode(int $value): void
    {
        $this->video_quality_mode = VideoQualityMode::tryFrom($value);
    }

    public function setDefaultSortOrder(?int $value): void
    {
        if (is_null($value)) {
            return;
        }

        $this->default_sort_order = SortOrderType::tryFrom($value);
    }

    public function setDefaultForumLayout(int $value): void
    {
        $this->default_forum_layout = ForumLayoutType::tryFrom($value);
    }
}
