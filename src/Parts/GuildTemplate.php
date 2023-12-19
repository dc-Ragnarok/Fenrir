<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Carbon\Carbon;

class GuildTemplate
{
    public string $code;
    public string $name;
    public ?string $description;
    public int $usage_count;
    public string $creator_id;
    public Carbon $created_at;
    public Carbon $updated_at;
    public string $source_guild_id;
    public Guild $guild;
    public ?bool $is_dirty;
}
