<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

class RoleSubscriptionData
{
    public string $role_subscription_listing_id;
    public string $tier_name;
    public int $total_months_subscribed;
    public bool $is_renewal;
}
