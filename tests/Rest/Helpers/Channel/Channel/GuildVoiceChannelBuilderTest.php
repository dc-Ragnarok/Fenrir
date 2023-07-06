<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Enums\ChannelTypes;
use Ragnarok\Fenrir\Enums\VideoQualityMode;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\GuildVoiceChannelBuilder;

class GuildVoiceChannelBuilderTest extends TestCase
{
    public function testConstructorSetsCorrectType(): void
    {
        $channelBuilder = new GuildVoiceChannelBuilder();

        $this->assertEquals([
            'type' => ChannelTypes::GUILD_VOICE->value
        ], $channelBuilder->get());
    }

    public function testSetUserLimit(): void
    {
        $channelBuilder = new GuildVoiceChannelBuilder();

        $channelBuilder->setUserLimit(50);

        $this->assertEquals(50, $channelBuilder->get()['user_limit']);

        $channelBuilder->setUserLimit(-1);

        $this->assertEquals(0, $channelBuilder->get()['user_limit']);

        $channelBuilder->setUserLimit(101);

        $this->assertEquals(100, $channelBuilder->get()['user_limit']);
    }

    public function testSetVideoQualityMode(): void
    {
        $channelBuilder = new GuildVoiceChannelBuilder();

        $channelBuilder->setVideoQualityMode(VideoQualityMode::AUTO);

        $this->assertEquals(VideoQualityMode::AUTO->value, $channelBuilder->get()['video_quality_mode']);
    }
}
