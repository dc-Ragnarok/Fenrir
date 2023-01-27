<?php

namespace Exan\Dhp\Rest\Helpers\Channel\Channel;

use Exan\Dhp\Enums\Parts\ChannelType;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetDefaultAutoArchiveDuration;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetDefaultThreadRateLimitPerUser;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetNsfw;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetParentId;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetRateLimitPerUser;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetTopic;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetType;

/**
 * @see https://discord.com/developers/docs/resources/channel#modify-channel
 */
class GuildTextChannelBuilder extends ChannelBuilder
{
    use SetType;
    use SetTopic;
    use SetNsfw;
    use SetRateLimitPerUser;
    use SetParentId;
    use SetDefaultAutoArchiveDuration;
    use SetDefaultThreadRateLimitPerUser;

    public function __construct()
    {
        $this->setChannelType(ChannelType::GUILD_TEXT);
    }
}
