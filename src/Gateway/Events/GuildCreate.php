<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Carbon\Carbon;
use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Parts\Guild;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#guild-create
 */
#[RequiresIntent(Intent::GUILDS)]
class GuildCreate extends Guild
{
    public Carbon $joined_at;
    public bool $large;
    public ?bool $unavailable;
    public int $member_count;

    /** @var \Ragnarok\Fenrir\Parts\VoiceState[] */
    public array $voice_states;

    /** @var \Ragnarok\Fenrir\Parts\GuildMember[] */
    public array $members;

    /** @var \Ragnarok\Fenrir\Parts\Channel[] */
    public array $channels;

    /** @var \Ragnarok\Fenrir\Parts\Channel[] */
    public array $threads;

    /** @var \Ragnarok\Fenrir\Parts\Presence[] */
    #[RequiresIntent(Intent::GUILD_PRESENCES)]
    public array $presences;

    /** @var \Ragnarok\Fenrir\Parts\StageInstance[] */
    public array $stage_instances;

    /** @var \Ragnarok\Fenrir\Parts\GuildScheduledEvent[] */
    public array $guild_scheduled_events;
}
