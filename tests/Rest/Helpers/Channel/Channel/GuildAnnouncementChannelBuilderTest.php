<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Enums\ChannelType;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\GuildAnnouncementChannelBuilder;

class GuildAnnouncementChannelBuilderTest extends TestCase
{
    public function testConstructorSetsCorrectType(): void
    {
        $channelBuilder = new GuildAnnouncementChannelBuilder();

        $this->assertEquals([
            'type' => ChannelType::GUILD_ANNOUNCEMENT->value
        ], $channelBuilder->get());
    }
}
