<?php

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\ChannelTypes;
use Carbon\Carbon;
use Exan\Dhp\Enums\Parts\VideoQualityModes;
use Exan\Dhp\Enums\Parts\SortOrderTypes;
use Exan\Dhp\Enums\Parts\ForumLayoutTypes;

class Channel
{
    public string $id;
    public ChannelTypes $type;
    public ?string $guild_id;
    public ?int $position;
    /** @var ?\Exan\Dhp\Parts\Overwrite[] */
    public ?array $permission_overwrites;
    public ?string $name;
    public ?string $topic;
    public ?bool $nsfw;
    public ?string $last_message_id;
    public ?int $bitrate;
    public ?int $user_limit;
    public ?int $rate_limit_per_user;
    /** @var ?\Exan\Dhp\Parts\User[] */
    public ?array $recipients;
    public ?string $icon;
    public ?string $owner_id;
    public ?string $application_id;
    public ?string $parent_id;
    public ?Carbon $last_pin_timestamp;
    public ?string $rtc_region;
    public ?VideoQualityModes $video_quality_mode;
    public ?int $message_count;
    public ?int $member_count;
    public ?ThreadMetadata $thread_metadata;
    public ?ThreadMember $member;
    public ?int $default_auto_archive_duration;
    public ?string $permissions;
    public ?string $flags;
    public ?int $total_message_sent;
    /** @var ?\Exan\Dhp\Parts\Tag[] */
    public ?array $available_tags;
    /** @var ?\Exan\Dhp\Parts\string[] */
    public ?array $applied_tags;
    public ?DefaultReaction $default_reaction_emoji;
    public ?int $default_thread_rate_limit_per_user;
    public ?SortOrderTypes $default_sort_order;
    public ?ForumLayoutTypes $default_forum_layout;
}
