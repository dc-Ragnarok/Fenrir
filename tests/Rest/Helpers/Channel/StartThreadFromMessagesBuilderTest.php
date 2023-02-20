<?php

declare(strict_types=1);

namespace Tests\Exan\Finrir\Rest\Helpers\Channel;

use Exan\Finrir\Const\Validation\RateLimit;
use Exan\Finrir\Enums\Parts\ThreadAutoArchiveDuration;
use Exan\Finrir\Rest\Helpers\Channel\StartThreadFromMessageBuilder;
use PHPUnit\Framework\TestCase;

class StartThreadFromMessageBuilderTest extends TestCase
{
    public function testSetName()
    {
        $builder = new StartThreadFromMessageBuilder();
        $builder->setName('test name');
        $this->assertEquals('test name', $builder->get()['name']);
    }

    public function testSetAutoArchiveDuration()
    {
        $builder = new StartThreadFromMessageBuilder();
        $builder->setAutoArchiveDuration(ThreadAutoArchiveDuration::MINUTES_60);
        $this->assertEquals(ThreadAutoArchiveDuration::MINUTES_60->value, $builder->get()['auto_archive_duration']);
    }

    public function testSetRateLimitPerUser()
    {
        $builder = new StartThreadFromMessageBuilder();
        $builder->setRateLimitPerUser(RateLimit::MIN - 1);
        $this->assertEquals(RateLimit::MIN, $builder->get()['rate_limit_per_user']);

        $builder->setRateLimitPerUser(RateLimit::MAX + 1);
        $this->assertEquals(RateLimit::MAX, $builder->get()['rate_limit_per_user']);

        $builder->setRateLimitPerUser(100);
        $this->assertEquals(100, $builder->get()['rate_limit_per_user']);
    }
}
