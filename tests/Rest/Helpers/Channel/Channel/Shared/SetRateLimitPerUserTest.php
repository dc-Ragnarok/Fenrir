<?php

declare(strict_types=1);

namespace Tests\Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared;

use Exan\Fenrir\Const\Validation\RateLimit;
use Exan\Fenrir\Rest\Helpers\Channel\Channel\Shared\SetRateLimitPerUser;
use PHPUnit\Framework\TestCase;

class SetRateLimitPerUserTest extends TestCase
{
    private function getTestClass()
    {
        return new class extends DummyTraitTester {
            use SetRateLimitPerUser;
        };
    }

    public function testSetNormalRateLimitPerUser()
    {
        $class = $this->getTestClass();
        $class->setRateLimitPerUser(RateLimit::MIN + 1);

        $this->assertEquals(['rate_limit_per_user' => RateLimit::MIN + 1], $class->get());
        $this->assertEquals(RateLimit::MIN + 1, $class->getRateLimitPerUser());
    }

    public function testSetBelowZeroRateLimitPerUser()
    {
        $class = $this->getTestClass();
        $class->setRateLimitPerUser(RateLimit::MIN - 1);

        $this->assertEquals(['rate_limit_per_user' => RateLimit::MIN], $class->get());
        $this->assertEquals(RateLimit::MIN, $class->getRateLimitPerUser());
    }

    public function testSetAboveMaxRateLimitPerUser()
    {
        $class = $this->getTestClass();
        $class->setRateLimitPerUser(RateLimit::MAX + 1);

        $this->assertEquals(['rate_limit_per_user' => RateLimit::MAX], $class->get());
        $this->assertEquals(RateLimit::MAX, $class->getRateLimitPerUser());
    }
}
