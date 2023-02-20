<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

use Carbon\Carbon;

class VoiceState
{
    public ?string $guild_id;
    public ?string $channel_id;
    public string $user_id;
    public ?GuildMember $member;
    public string $session_id;
    public bool $deaf;
    public bool $mute;
    public bool $self_deaf;
    public bool $self_mute;
    public ?bool $self_stream;
    public bool $self_video;
    public bool $suppress;
    public ?Carbon $request_to_speak_timestamp;
}
