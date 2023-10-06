<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Carbon\Carbon;
use Ragnarok\Fenrir\Enums\GuildScheduledEventEntityType;
use Ragnarok\Fenrir\Enums\GuildScheduledEventPrivacyLevel;
use Ragnarok\Fenrir\Enums\GuildScheduledEventStatus;

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
    public GuildScheduledEventPrivacyLevel $privacy_level;
    public GuildScheduledEventStatus $status;
    public GuildScheduledEventEntityType $entity_type;
    public ?string $entity_id;
    public ?GuildScheduledEventEntityMetadata $entity_metadata;
    public User $creator;
    public ?int $user_count;
    public ?string $image;

    public function setPrivacyLevel(int $value): void
    {
        $this->privacy_level = GuildScheduledEventPrivacyLevel::tryFrom($value);
    }

    public function setStatus(int $value): void
    {
        $this->status = GuildScheduledEventStatus::tryFrom($value);
    }

    public function setEntityType(int $value): void
    {
        $this->entity_type = GuildScheduledEventEntityType::tryFrom($value);
    }
}
