<?php

declare(strict_types=1);

namespace Tests\Exan\Finrir\Rest\Helpers\Channel\Channel\Shared;

use Exan\Finrir\Enums\Parts\ChannelTypes;
use Exan\Finrir\Rest\Helpers\Channel\Channel\GuildTextChannelBuilder;
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
