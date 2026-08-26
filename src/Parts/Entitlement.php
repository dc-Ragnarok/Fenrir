<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Carbon\Carbon;
use Ragnarok\Fenrir\Enums\EntitlementType;

/**
 * @see https://discord.com/developers/docs/resources/entitlement#entitlement-object
 */
class Entitlement
{
    public string $id;
    public string $sku_id;
    public string $application_id;
    public ?string $user_id;
    public EntitlementType $type;
    public bool $deleted;
    public ?Carbon $starts_at;
    public ?Carbon $ends_at;
    public ?string $guild_id;
    public bool $consumed;
}
