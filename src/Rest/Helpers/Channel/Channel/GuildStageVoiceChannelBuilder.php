<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers\Channel\Channel;

use Exan\Finrir\Enums\Parts\ChannelTypes;
use Exan\Finrir\Rest\Helpers\Channel\Channel\Shared\SetBitrate;
use Exan\Finrir\Rest\Helpers\Channel\Channel\Shared\SetRtcRegion;

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
