<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel;

use PHPUnit\Framework\TestCase;
use Ragnarok\Fenrir\Constants\Validation\RateLimit;
use Ragnarok\Fenrir\Enums\ThreadAutoArchiveDuration;
use Ragnarok\Fenrir\Rest\Helpers\Channel\StartThreadFromMessageBuilder;

class StartThreadFromMessageBuilderTest extends TestCase
{
    public function testSetName(): void
    {
        $builder = new StartThreadFromMessageBuilder();
        $builder->setName('test name');
        $this->assertEquals('test name', $builder->get()['name']);
        $this->assertEquals('test name', $builder->getName());
    }

    public function testSetAutoArchiveDuration(): void
    {
        $builder = new StartThreadFromMessageBuilder();
        $builder->setAutoArchiveDuration(ThreadAutoArchiveDuration::MINUTES_60);
        $this->assertEquals(ThreadAutoArchiveDuration::MINUTES_60->value, $builder->get()['auto_archive_duration']);
        $this->assertEquals(ThreadAutoArchiveDuration::MINUTES_60, $builder->getAutoArchiveDuration());
    }

    public function testSetRateLimitPerUser(): void
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
