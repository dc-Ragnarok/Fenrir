<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Channel;

use Exan\Fenrir\Enums\Parts\ChannelTypes;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetDefaultAutoArchiveDuration;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetNsfw;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetParentId;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetTopic;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetType;

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
