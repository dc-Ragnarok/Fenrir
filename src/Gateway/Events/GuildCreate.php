<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events;

use Carbon\Carbon;
use Ragnarok\Fenrir\Attributes\RequiresIntent;
use Ragnarok\Fenrir\Enums\Intent;
use Ragnarok\Fenrir\Mapping\ArrayMapping;
use Ragnarok\Fenrir\Parts\Channel;
use Ragnarok\Fenrir\Parts\Guild;
use Ragnarok\Fenrir\Parts\GuildMember;
use Ragnarok\Fenrir\Parts\GuildScheduledEvent;
use Ragnarok\Fenrir\Parts\Presence;
use Ragnarok\Fenrir\Parts\StageInstance;
use Ragnarok\Fenrir\Parts\VoiceState;

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

    /** @var VoiceState[] */
    #[ArrayMapping(VoiceState::class)]
    public array $voice_states;

    /** @var GuildMember[] */
    #[ArrayMapping(GuildMember::class)]
    public array $members;

    /** @var Channel[] */
    #[ArrayMapping(Channel::class)]
    public array $channels;

    /** @var Channel[] */
    #[ArrayMapping(Channel::class)]
    public array $threads;

    /** @var Presence[] */
    #[RequiresIntent(Intent::GUILD_PRESENCES)]
    #[ArrayMapping(Presence::class)]
    public array $presences;

    /** @var StageInstance[] */
    #[ArrayMapping(StageInstance::class)]
    public array $stage_instances;

    /** @var GuildScheduledEvent[] */
    #[ArrayMapping(GuildScheduledEvent::class)]
    public array $guild_scheduled_events;
}
