<?php

declare(strict_types=1);

namespace Tests\Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

use Exan\Dhp\Enums\Parts\ChannelTypes;
use Exan\Dhp\Rest\Helpers\Channel\Channel\GuildAnnouncementChannelBuilder;
use PHPUnit\Framework\TestCase;

class GuildAnnouncementChannelBuilderTest extends TestCase
{
    public function testConstructorSetsCorrectType()
    {
        $channelBuilder = new GuildAnnouncementChannelBuilder();

        $this->assertEquals([
            'type' => ChannelTypes::GUILD_ANNOUNCEMENT->value
        ], $channelBuilder->get());
    }
}
