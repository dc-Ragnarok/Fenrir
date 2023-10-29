<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Carbon\Carbon;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Enums\ChannelType;
use Ragnarok\Fenrir\Enums\ForumLayoutType;
use Ragnarok\Fenrir\Enums\SortOrderType;
use Ragnarok\Fenrir\Enums\VideoQualityMode;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

class Channel
{
    public string $id;
    public ChannelType $type;
    public ?string $guild_id;
    public ?int $position;
    /**
     * @var Overwrite[]
     */
    #[ArrayMapping(Overwrite::class)]
    public ?array $permission_overwrites;
    public ?string $name;
    public ?string $topic;
    public ?bool $nsfw;
    public ?string $last_message_id;
    public ?int $bitrate;
    public ?int $user_limit;
    public ?int $rate_limit_per_user;
    /**
     * @var User[]
     */
    #[ArrayMapping(User::class)]
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
     * @var Tag[]
     */
    #[ArrayMapping(Tag::class)]
    public ?array $available_tags;
    /**
     * @var string[]
     */
    public ?array $applied_tags;
    public ?DefaultReaction $default_reaction_emoji;
    public ?int $default_thread_rate_limit_per_user;
    public ?SortOrderType $default_sort_order;
    public ?ForumLayoutType $default_forum_layout;
}
