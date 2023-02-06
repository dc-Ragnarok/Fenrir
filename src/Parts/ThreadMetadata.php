<?php

namespace Exan\Dhp\Parts;

use Carbon\Carbon;

/**
 * @see https://discord.com/developers/docs/resources/channel#thread-metadata-object
 */
class ThreadMetadata
{
    public bool $archived;
    public int $auto_archive_duration;
    public Carbon $archive_timestamp;
    public bool $locked;
    public ?bool $invitable;
    public ?Carbon $create_timestamp;
}
