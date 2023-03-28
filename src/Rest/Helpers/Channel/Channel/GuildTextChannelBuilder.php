<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Channel;

use Ragnarok\Fenrir\Enums\Parts\ChannelTypes;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetDefaultAutoArchiveDuration;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetDefaultThreadRateLimitPerUser;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetNsfw;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetParentId;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetRateLimitPerUser;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetTopic;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetType;

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
