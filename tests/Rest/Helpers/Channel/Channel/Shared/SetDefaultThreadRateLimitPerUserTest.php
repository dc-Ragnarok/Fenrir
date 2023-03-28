<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Ragnarok\Fenrir\Constants\Validation\RateLimit;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetDefaultThreadRateLimitPerUser;
use PHPUnit\Framework\TestCase;

class SetDefaultThreadRateLimitPerUserTest extends TestCase
{
    public function testSetThreadRateLimitPerUser(): void
    {
        $class = new class extends DummyTraitTester {
            use SetDefaultThreadRateLimitPerUser;
        };

        $class->setDefaultThreadRateLimitPerUser(RateLimit::MIN + 1);

        $this->assertEquals(['default_thread_rate_limit_per_user' => RateLimit::MIN + 1], $class->get());
        $this->assertEquals(RateLimit::MIN + 1, $class->getDefaultThreadRateLimitPerUser());
    }

    public function testSetThreadRateLimitAboveMaxPerUser(): void
    {
        $class = new class extends DummyTraitTester {
            use SetDefaultThreadRateLimitPerUser;
        };

        $class->setDefaultThreadRateLimitPerUser(RateLimit::MAX + 1);

        $this->assertEquals(['default_thread_rate_limit_per_user' => RateLimit::MAX], $class->get());
        $this->assertEquals(RateLimit::MAX, $class->getDefaultThreadRateLimitPerUser());
    }

    public function testSetThreadRateLimitBelowMinPerUser(): void
    {
        $class = new class extends DummyTraitTester {
            use SetDefaultThreadRateLimitPerUser;
        };

        $class->setDefaultThreadRateLimitPerUser(RateLimit::MIN - 1);

        $this->assertEquals(['default_thread_rate_limit_per_user' => RateLimit::MIN], $class->get());
        $this->assertEquals(RateLimit::MIN, $class->getDefaultThreadRateLimitPerUser());
    }
}
