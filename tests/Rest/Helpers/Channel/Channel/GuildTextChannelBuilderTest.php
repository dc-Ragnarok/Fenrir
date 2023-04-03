<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel;

use Ragnarok\Fenrir\Enums\Parts\ChannelTypes;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\GuildTextChannelBuilder;
use PHPUnit\Framework\TestCase;

class GuildTextChannelBuilderTest extends TestCase
{
    public function testConstructorSetsCorrectType(): void
    {
        $channelBuilder = new GuildTextChannelBuilder();

        $this->assertEquals([
            'type' => ChannelTypes::GUILD_TEXT->value
        ], $channelBuilder->get());
    }
}
