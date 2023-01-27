<?php

namespace Tests\Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

use Exan\Dhp\Enums\Parts\ChannelType;
use Exan\Dhp\Rest\Helpers\Channel\Channel\GuildStageVoiceChannelBuilder;
use PHPUnit\Framework\TestCase;

class GuildStageVoiceChannelBuilderTest extends TestCase
{
    public function testConstructorSetsCorrectType()
    {
        $channelBuilder = new GuildStageVoiceChannelBuilder();

        $this->assertEquals([
            'type' => ChannelType::GUILD_STAGE_VOICE->value
        ], $channelBuilder->get());
    }
}
