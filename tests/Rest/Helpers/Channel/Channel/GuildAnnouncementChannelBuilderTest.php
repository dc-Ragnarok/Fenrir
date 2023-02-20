<?php

declare(strict_types=1);

namespace Tests\Exan\Finrir\Rest\Helpers\Channel\Channel\Shared;

use Exan\Finrir\Enums\Parts\ChannelTypes;
use Exan\Finrir\Rest\Helpers\Channel\Channel\GuildAnnouncementChannelBuilder;
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
