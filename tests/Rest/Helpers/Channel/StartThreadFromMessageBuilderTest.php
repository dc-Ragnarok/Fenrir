<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\Channel;

use Exan\Fenrir\Const\Validation\RateLimit;
use Exan\Fenrir\Enums\Parts\ThreadAutoArchiveDuration;
use Exan\Fenrir\Rest\Helpers\Channel\StartThreadFromMessageBuilder;
use PHPUnit\Framework\TestCase;

class StartThreadFromMessageBuilderTest extends TestCase
{
    public function testSetName()
    {
        $builder = new StartThreadFromMessageBuilder();
        $builder->setName('test name');
        $this->assertEquals('test name', $builder->get()['name']);
        $this->assertEquals('test name', $builder->getName());
    }

    public function testSetAutoArchiveDuration()
    {
        $builder = new StartThreadFromMessageBuilder();
        $builder->setAutoArchiveDuration(ThreadAutoArchiveDuration::MINUTES_60);
        $this->assertEquals(ThreadAutoArchiveDuration::MINUTES_60->value, $builder->get()['auto_archive_duration']);
        $this->assertEquals(ThreadAutoArchiveDuration::MINUTES_60, $builder->getAutoArchiveDuration());
    }

    public function testSetRateLimitPerUser()
    {
        $builder = new StartThreadFromMessageBuilder();
        $builder->setRateLimitPerUser(RateLimit::MIN - 1);
        $this->assertEquals(RateLimit::MIN, $builder->get()['rate_limit_per_user']);
        $this->assertEquals(RateLimit::MIN, $builder->getRateLimitPerUser());

        $builder->setRateLimitPerUser(RateLimit::MAX + 1);
        $this->assertEquals(RateLimit::MAX, $builder->get()['rate_limit_per_user']);
        $this->assertEquals(RateLimit::MAX, $builder->getRateLimitPerUser());

        $builder->setRateLimitPerUser(100);
        $this->assertEquals(100, $builder->get()['rate_limit_per_user']);
        $this->assertEquals(100, $builder->getRateLimitPerUser());
    }
}
