<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

use Carbon\Carbon;
use Exan\Dhp\Enums\Parts\ActivityType;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#activity-object
 */
class Activity
{
    public string $name;
    public ActivityType $type;
    public ?string $url;
    public Carbon $created_At;
    public $timestamps;
    public string $application_id;
    public ?string $details;
    public ?string $state;
    public ?Emoji $emoji;
    public ActivityParty $party;
    public ActivityAssets $assets;
    public $secrets;
    public ?bool $instance;
    public $flags;

    /**
     * @var ActivityButton[]
     */
    public array $buttons;
}
