<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Exan\Fenrir\Enums\Parts\ChannelTypes;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\GuildTextChannelBuilder;
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
