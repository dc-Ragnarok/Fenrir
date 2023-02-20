<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Exan\Fenrir\Enums\Parts\ActivityTypes;
use Carbon\Carbon;
use Exan\Fenrir\Bitwise\Bitwise;

class Activity
{
    public string $name;
    public ActivityTypes $type;
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
     * @var \Exan\Fenrir\Parts\ActivityButton[]
     */
    public ?array $buttons;

    public function setType(int $value): void
    {
        $this->type = ActivityTypes::from($value);
    }
}
