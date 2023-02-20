<?php

declare(strict_types=1);

namespace Tests\Exan\Finrir\Rest\Helpers\Channel\Channel\Shared;

use Exan\Finrir\Enums\Parts\ChannelTypes;
use Exan\Finrir\Rest\Helpers\Channel\Channel\GuildStageVoiceChannelBuilder;
use PHPUnit\Framework\TestCase;

class GuildStageVoiceChannelBuilderTest extends TestCase
{
    public function testConstructorSetsCorrectType()
    {
        $channelBuilder = new GuildStageVoiceChannelBuilder();

        $this->assertEquals([
            'type' => ChannelTypes::GUILD_STAGE_VOICE->value
        ], $channelBuilder->get());
    }
}
