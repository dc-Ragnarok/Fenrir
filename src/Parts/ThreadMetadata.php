<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Carbon\Carbon;

class ThreadMetadata
{
    public bool $archived;
    public int $auto_archive_duration;
    public Carbon $archive_timestamp;
    public bool $locked;
    public ?bool $invitable;
    public ?Carbon $create_timestamp;
}
