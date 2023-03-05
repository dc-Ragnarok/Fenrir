<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Channel;

use Exan\Fenrir\Enums\Parts\ChannelTypes;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetDefaultAutoArchiveDuration;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetDefaultThreadRateLimitPerUser;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetNsfw;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetParentId;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetRateLimitPerUser;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetTopic;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetType;

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
        $this->setChannelType(ChannelTypes::GUILD_TEXT);
    }
}
