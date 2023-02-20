<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers\Channel\Channel;

use Exan\Finrir\Enums\Parts\ChannelTypes;
use Exan\Finrir\Rest\Helpers\Channel\Channel\Shared\SetDefaultAutoArchiveDuration;
use Exan\Finrir\Rest\Helpers\Channel\Channel\Shared\SetNsfw;
use Exan\Finrir\Rest\Helpers\Channel\Channel\Shared\SetParentId;
use Exan\Finrir\Rest\Helpers\Channel\Channel\Shared\SetTopic;
use Exan\Finrir\Rest\Helpers\Channel\Channel\Shared\SetType;

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
