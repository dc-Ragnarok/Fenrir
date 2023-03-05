<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Channel;

use Ragnarok\Fenrir\Enums\Parts\ChannelTypes;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetDefaultAutoArchiveDuration;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetNsfw;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetParentId;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetTopic;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetType;

/**
 * @see https://discord.com/developers/docs/resources/channel#modify-channel
 */
class GuildAnnouncementChannelBuilder extends ChannelBuilder
{
    use SetType;
    use SetTopic;
    use SetNsfw;
    use SetParentId;
    use SetDefaultAutoArchiveDuration;

    public function __construct()
    {
        $this->setChannelType(ChannelTypes::GUILD_ANNOUNCEMENT);
    }
}
