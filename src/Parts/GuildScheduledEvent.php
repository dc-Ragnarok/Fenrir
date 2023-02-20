<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

use Carbon\Carbon;
use Exan\Finrir\Enums\Parts\GuildScheduledEventPrivacyLevels;
use Exan\Finrir\Enums\Parts\GuildScheduledEventStatus;
use Exan\Finrir\Enums\Parts\GuildScheduledEventEntityTypes;

class GuildScheduledEvent
{
    public string $id;
    public string $guild_id;
    public ?string $channel_id;
    public ?string $creator_id;
    public string $name;
    public ?string $description;
    public Carbon $scheduled_start_time;
    public ?Carbon $scheduled_end_time;
    public GuildScheduledEventPrivacyLevels $privacy_level;
    public GuildScheduledEventStatus $status;
    public GuildScheduledEventEntityTypes $entity_type;
    public ?string $entity_id;
    public ?GuildScheduledEventEntityMetadata $entity_metadata;
    public User $creator;
    public ?int $user_count;
    public ?string $image;

    public function setPrivacyLevel(int $value): void
    {
        $this->privacy_level = GuildScheduledEventPrivacyLevels::from($value);
    }

    public function setStatus(int $value): void
    {
        $this->status = GuildScheduledEventStatus::from($value);
    }

    public function setEntityType(int $value): void
    {
        $this->entity_type = GuildScheduledEventEntityTypes::from($value);
    }
}
