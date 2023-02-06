<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

use Carbon\Carbon;
use Exan\Dhp\Enums\Parts\ChannelFlags;
use Exan\Dhp\Enums\Parts\ChannelType;
use Exan\Dhp\Enums\Parts\VideoQualityMode;

/**
 * @see https://discord.com/developers/docs/resources/channel#channel-object
 */
class Channel
{
    public string $id;
    public ChannelType $type;
    public ?string $guild_id;
    public int $position;

    /**
     * @var \Exan\Dhp\Parts\Overwrite
     */
    public array $permission_overwrites;

    public ?string $name;
    public ?string $topic;
    public ?bool $nsfw;
    public ?string $last_message_id;
    public ?int $bitrate;
    public ?int $user_limit;

    /**
     * Seconds
     */
    public ?int $rate_limit_per_user;

    /**
     * @var \Exan\Dhp\Parts\User[]
     */
    public array $recipients;

    public ?string $owner_id;
    public ?string $application_id;
    public ?string $parent_id;
    public ?Carbon $last_pin_timestamp;
    public ?string $rtc_region;
    public ?VideoQualityMode $video_quality_mode;
    public ?int $message_count;
    public ?ThreadMetadata $thread_metadata;
    public ?ThreadMember $member;

    /**
     * Minutes
     */
    public ?int $default_auto_archive_duration;

    public ?string $permissions;
    public ?ChannelFlags $flags;
    public ?int $total_messages_sent;

    /**
     * @var \Exan\Dhp\Parts\ForumTag[]
     */
    public ?array $available_tags;

    /**
     * @var string[]
     */
    public ?array $applied_tags;

    public ?DefaultReactionEmoji $default_reaction_emoji;
    public ?int $default_sort_order;
    public ?int $default_forum_layout;
}
