<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Const\Validation\RateLimit;
use Ragnarok\Fenrir\Enums\Parts\ChannelTypes;
use Ragnarok\Fenrir\Enums\Parts\ThreadAutoArchiveDuration;
use Ragnarok\Fenrir\Rest\Helpers\Channel\StartThreadWithoutMessageBuilder;
use PHPUnit\Framework\TestCase;

class StartThreadWithoutMessageBuilderTest extends TestCase
{
    public function testSetName()
    {
        $builder = new StartThreadWithoutMessageBuilder();
        $builder->setName('test name');
        $this->assertEquals('test name', $builder->get()['name']);
    }

    public function testSetAutoArchiveDuration()
    {
        $builder = new StartThreadWithoutMessageBuilder();
        $builder->setAutoArchiveDuration(ThreadAutoArchiveDuration::MINUTES_60);
        $this->assertEquals(ThreadAutoArchiveDuration::MINUTES_60->value, $builder->get()['auto_archive_duration']);
    }

    public function testSetRateLimitPerUser()
    {
        $builder = new StartThreadWithoutMessageBuilder();
        $builder->setRateLimitPerUser(RateLimit::MIN - 1);
        $this->assertEquals(RateLimit::MIN, $builder->get()['rate_limit_per_user']);

        $builder->setRateLimitPerUser(RateLimit::MAX + 1);
        $this->assertEquals(RateLimit::MAX, $builder->get()['rate_limit_per_user']);

        $builder->setRateLimitPerUser(100);
        $this->assertEquals(100, $builder->get()['rate_limit_per_user']);
    }

    public function testSetType()
    {
        $builder = new StartThreadWithoutMessageBuilder();

        $builder->setType(ChannelTypes::DM);

        $this->assertEquals(['type' => ChannelTypes::DM->value], $builder->get());
    }

    public function testSetInvitable()
    {
        $builder = new StartThreadWithoutMessageBuilder();

        $builder->setInvitable(false);

        $this->assertEquals(['invitable' => false], $builder->get());
    }
}
