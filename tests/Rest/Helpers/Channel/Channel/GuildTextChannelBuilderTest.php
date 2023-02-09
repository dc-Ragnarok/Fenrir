<?php

namespace Tests\Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

use Exan\Dhp\Enums\Parts\ChannelTypes;
use Exan\Dhp\Rest\Helpers\Channel\Channel\GuildTextChannelBuilder;
use PHPUnit\Framework\TestCase;

class GuildTextChannelBuilderTest extends TestCase
{
    public function testConstructorSetsCorrectType()
    {
        $channelBuilder = new GuildTextChannelBuilder();

        $this->assertEquals([
            'type' => ChannelTypes::GUILD_TEXT->value
        ], $channelBuilder->get());
    }
}
