<?php

namespace Tests\Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

use Exan\Dhp\Const\Validation\RateLimit;
use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetRateLimitPerUser;
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
    }

    public function testSetBelowZeroRateLimitPerUser()
    {
        $class = $this->getTestClass();
        $class->setRateLimitPerUser(RateLimit::MIN - 1);

        $this->assertEquals(['rate_limit_per_user' => RateLimit::MIN], $class->get());
    }

    public function testSetAboveMaxRateLimitPerUser()
    {
        $class = $this->getTestClass();
        $class->setRateLimitPerUser(RateLimit::MAX + 1);

        $this->assertEquals(['rate_limit_per_user' => RateLimit::MAX], $class->get());
    }
}
