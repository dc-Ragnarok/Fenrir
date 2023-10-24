<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Carbon\Carbon;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Enums\ActivityType;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

class Activity
{
    public string $name;
    public ActivityType $type;
    public ?string $url;
    public Carbon $created_at;
    public ?ActivityTimestamps $timestamps;
    public ?string $application_id;
    public ?string $details;
    public ?string $state;
    public ?ActivityEmoji $emoji;
    public ?ActivityParty $party;
    public ?ActivityAssets $assets;
    public ?ActivitySecrets $secrets;
    public bool $instance;
    public ?Bitwise $flags;
    /**
     * @var \Ragnarok\Fenrir\Parts\ActivityButton[]
     */
    #[ArrayMapping(ActivityButton::class)]
    public ?array $buttons;
}
