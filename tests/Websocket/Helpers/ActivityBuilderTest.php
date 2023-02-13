<?php

namespace Tests\Exan\Dhp\Websocket\Helpers;

use Exan\Dhp\Enums\Gateway\ActivityType;
use Exan\Dhp\Parts\Emoji;
use Exan\Dhp\Rest\Helpers\Emoji\EmojiBuilder;
use Exan\Dhp\Websocket\Helpers\ActivityBuilder;
use PHPUnit\Framework\TestCase;

class ActivityBuilderTest extends TestCase
{
    public function testSetName(): void
    {
        $activityBuilder = new ActivityBuilder();
        $activityBuilder->setName('Test Activity');
        $this->assertEquals(['name' => 'Test Activity'], $activityBuilder->get());
    }

    public function testSetType(): void
    {
        $activityBuilder = new ActivityBuilder();
        $activityBuilder->setType(ActivityType::GAME);
        $this->assertEquals(['type' => ActivityType::GAME->value], $activityBuilder->get());
    }

    public function testSetUrl(): void
    {
        $activityBuilder = new ActivityBuilder();
        $activityBuilder->setUrl('https://www.test.com');
        $this->assertEquals(['url' => 'https://www.test.com'], $activityBuilder->get());
    }

    public function testSetEmoji(): void
    {
        $activityBuilder = new ActivityBuilder();
        $emoji = (new EmojiBuilder())->setId('::emoji id::')->setName('::emoji name::');
        $activityBuilder->setEmoji($emoji);
        $this->assertEquals(['emoji' => $emoji->get()], $activityBuilder->get());
    }
}
