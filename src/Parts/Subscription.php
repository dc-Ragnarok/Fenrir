<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Carbon\Carbon;
use Ragnarok\Fenrir\Enums\SubscriptionStatus;

/**
 * @see https://discord.com/developers/docs/resources/subscription#subscription-object
 */
class Subscription
{
    public string $id;
    public string $user_id;
    /** @var string[] */
    public array $sku_ids;
    /** @var string[] */
    public array $entitlement_ids;
    /** @var ?string[] */
    public ?array $renewal_sku_ids;
    public Carbon $current_period_start;
    public Carbon $current_period_end;
    public SubscriptionStatus $status;
    public ?Carbon $canceled_at;
    public ?string $country;
}
