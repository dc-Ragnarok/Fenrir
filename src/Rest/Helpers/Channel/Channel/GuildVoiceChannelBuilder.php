<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Channel;

use Exan\Fenrir\Enums\Parts\ChannelTypes;
use Exan\Fenrir\Enums\Parts\VideoQualityModes;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetBitrate;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetNsfw;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetParentId;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetRtcRegion;

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
        $this->setChannelType(ChannelTypes::GUILD_VOICE);
    }

    public function setUserLimit(int $limit): GuildVoiceChannelBuilder
    {
        $this->data['user_limit'] = min(max($limit, 0), 100);

        return $this;
    }

    public function setVideoQualityMode(VideoQualityModes $quality)
    {
        $this->data['video_quality_mode'] = $quality->value;
    }
}
