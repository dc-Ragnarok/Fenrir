<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Websocket\Helpers;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Enums\ActivityType;
use Ragnarok\Fenrir\Gateway\Helpers\ActivityBuilder;
use Ragnarok\Fenrir\Rest\Helpers\Emoji\EmojiBuilder;

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
