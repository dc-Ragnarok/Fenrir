<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

class RoleTags
{
    public ?string $bot_id;
    public ?string $integration_id;
    /**
     * @var ?null Use isset() to check whether this property is set and use that, Discord weirdness
     */
    public mixed $premium_subscriber;
    public ?string $subscription_listing_id;
    /**
     * @var ?null Use isset() to check whether this property is set and use that, Discord weirdness
     */
    public mixed $available_for_purchase;
    /**
     * @var ?null Use isset() to check whether this property is set and use that, Discord weirdness
     */
    public mixed $guild_connections;
}
