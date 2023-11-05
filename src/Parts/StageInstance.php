<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\PrivacyLevel;

class StageInstance
{
    public string $id;
    public string $guild_id;
    public string $channel_id;
    public string $topic;
    public PrivacyLevel $privacy_level;
    public bool $discoverable_disabled;
    public ?string $guild_scheduled_event_id;
}
