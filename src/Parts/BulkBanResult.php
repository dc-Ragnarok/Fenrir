<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

/**
 * @see https://discord.com/developers/docs/resources/guild#bulk-guild-ban
 */
class BulkBanResult
{
    /** @var string[] */
    public array $banned_users;
    /** @var string[] */
    public array $failed_users;
}
