<?php

namespace Exan\Dhp\Rest\Helpers\Channel\Channel;

use Exan\Dhp\Enums\Parts\ChannelType;
use Exan\Dhp\Enums\Parts\VideoQualityMode;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetBitrate;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetNsfw;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetParentId;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetRtcRegion;

/**
 * @see https://discord.com/developers/docs/resources/channel#modify-channel
 */
class GuildVoiceChannelBuilder extends ChannelBuilder
{
    use SetNsfw;
    use SetBitrate;
    use SetParentId;
    use SetRtcRegion;

    public function __construct()
    {
        $this->setChannelType(ChannelType::GUILD_VOICE);
    }

    public function setUserLimit(int $limit): GuildVoiceChannelBuilder
    {
        $this->data['user_limit'] = min(max($limit, 0), 100);

        return $this;
    }

    public function setVideoQualityMode(VideoQualityMode $quality)
    {
        $this->data['video_quality_mode'] = $quality->value;
    }
}
