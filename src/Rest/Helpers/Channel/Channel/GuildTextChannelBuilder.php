<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers\Channel\Channel;

use Exan\Finrir\Enums\Parts\ChannelTypes;
use Exan\Finrir\Rest\Helpers\Channel\Channel\Shared\SetDefaultAutoArchiveDuration;
use Exan\Finrir\Rest\Helpers\Channel\Channel\Shared\SetDefaultThreadRateLimitPerUser;
use Exan\Finrir\Rest\Helpers\Channel\Channel\Shared\SetNsfw;
use Exan\Finrir\Rest\Helpers\Channel\Channel\Shared\SetParentId;
use Exan\Finrir\Rest\Helpers\Channel\Channel\Shared\SetRateLimitPerUser;
use Exan\Finrir\Rest\Helpers\Channel\Channel\Shared\SetTopic;
use Exan\Finrir\Rest\Helpers\Channel\Channel\Shared\SetType;

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
