<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Enums\ChannelType;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\GuildTextChannelBuilder;

class GuildTextChannelBuilderTest extends TestCase
{
    public function testConstructorSetsCorrectType(): void
    {
        $channelBuilder = new GuildTextChannelBuilder();

        $this->assertEquals([
            'type' => ChannelType::GUILD_TEXT->value
        ], $channelBuilder->get());
    }
}
