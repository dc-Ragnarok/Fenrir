<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\Channel\Channel;

use Exan\Fenrir\Enums\Parts\ChannelTypes;
use Exan\Fenrir\Enums\Parts\VideoQualityModes;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\GuildVoiceChannelBuilder;
use PHPUnit\Framework\TestCase;

class GuildVoiceChannelBuilderTest extends TestCase
{
    public function testConstructorSetsCorrectType()
    {
        $channelBuilder = new GuildVoiceChannelBuilder();

        $this->assertEquals([
            'type' => ChannelTypes::GUILD_VOICE->value
        ], $channelBuilder->get());
    }

    public function testSetUserLimit()
    {
        $channelBuilder = new GuildVoiceChannelBuilder();

        $channelBuilder->setUserLimit(50);

        $this->assertEquals(50, $channelBuilder->get()['user_limit']);

        $channelBuilder->setUserLimit(-1);

        $this->assertEquals(0, $channelBuilder->get()['user_limit']);

        $channelBuilder->setUserLimit(101);

        $this->assertEquals(100, $channelBuilder->get()['user_limit']);
    }

    public function testSetVideoQualityMode()
    {
        $channelBuilder = new GuildVoiceChannelBuilder();

        $channelBuilder->setVideoQualityMode(VideoQualityModes::AUTO);

        $this->assertEquals(VideoQualityModes::AUTO->value, $channelBuilder->get()['video_quality_mode']);
    }
}
