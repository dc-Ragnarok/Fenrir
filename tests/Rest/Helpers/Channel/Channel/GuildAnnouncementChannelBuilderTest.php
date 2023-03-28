<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel;

use Ragnarok\Fenrir\Enums\Parts\ChannelTypes;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\GuildAnnouncementChannelBuilder;
use PHPUnit\Framework\TestCase;

class GuildAnnouncementChannelBuilderTest extends TestCase
{
    public function testConstructorSetsCorrectType(): void
    {
        $channelBuilder = new GuildAnnouncementChannelBuilder();

        $this->assertEquals([
            'type' => ChannelTypes::GUILD_ANNOUNCEMENT->value
        ], $channelBuilder->get());
    }
}
