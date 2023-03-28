<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Channel;

use Ragnarok\Fenrir\Enums\Parts\ChannelTypes;
use Ragnarok\Fenrir\Enums\Parts\VideoQualityModes;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetBitrate;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetNsfw;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetParentId;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetRtcRegion;

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

    public function setVideoQualityMode(VideoQualityModes $quality): void
    {
        $this->data['video_quality_mode'] = $quality->value;
    }
}
