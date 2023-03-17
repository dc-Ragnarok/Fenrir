<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Exan\Fenrir\Constants\Validation\RateLimit;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetDefaultThreadRateLimitPerUser;
use PHPUnit\Framework\TestCase;

class SetDefaultThreadRateLimitPerUserTest extends TestCase
{
    public function testSetThreadRateLimitPerUser()
    {
        $class = new class extends DummyTraitTester {
            use SetDefaultThreadRateLimitPerUser;
        };

        $class->setDefaultThreadRateLimitPerUser(RateLimit::MIN + 1);

        $this->assertEquals(['default_thread_rate_limit_per_user' => RateLimit::MIN + 1], $class->get());
        $this->assertEquals(RateLimit::MIN + 1, $class->getDefaultThreadRateLimitPerUser());
    }

    public function testSetThreadRateLimitAboveMaxPerUser()
    {
        $class = new class extends DummyTraitTester {
            use SetDefaultThreadRateLimitPerUser;
        };

        $class->setDefaultThreadRateLimitPerUser(RateLimit::MAX + 1);

        $this->assertEquals(['default_thread_rate_limit_per_user' => RateLimit::MAX], $class->get());
        $this->assertEquals(RateLimit::MAX, $class->getDefaultThreadRateLimitPerUser());
    }

    public function testSetThreadRateLimitBelowMinPerUser()
    {
        $class = new class extends DummyTraitTester {
            use SetDefaultThreadRateLimitPerUser;
        };

        $class->setDefaultThreadRateLimitPerUser(RateLimit::MIN - 1);

        $this->assertEquals(['default_thread_rate_limit_per_user' => RateLimit::MIN], $class->get());
        $this->assertEquals(RateLimit::MIN, $class->getDefaultThreadRateLimitPerUser());
    }
}
