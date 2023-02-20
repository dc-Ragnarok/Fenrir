<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Channel;

use Exan\Fenrir\Enums\Parts\ChannelTypes;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetBitrate;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetRtcRegion;

/**
 * @see https://discord.com/developers/docs/resources/channel#modify-channel
 */
class GuildStageVoiceChannelBuilder extends ChannelBuilder
{
    use SetBitrate;
    use SetRtcRegion;

    public function __construct()
    {
        $this->setChannelType(ChannelTypes::GUILD_STAGE_VOICE);
    }
}
