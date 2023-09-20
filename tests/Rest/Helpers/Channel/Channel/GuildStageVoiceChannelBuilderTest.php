<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Enums\ChannelType;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\GuildStageVoiceChannelBuilder;

class GuildStageVoiceChannelBuilderTest extends TestCase
{
    public function testConstructorSetsCorrectType(): void
    {
        $channelBuilder = new GuildStageVoiceChannelBuilder();

        $this->assertEquals([
            'type' => ChannelType::GUILD_STAGE_VOICE->value
        ], $channelBuilder->get());
    }
}
