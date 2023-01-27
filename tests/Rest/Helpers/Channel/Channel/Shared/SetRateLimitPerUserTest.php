<?php

namespace Tests\Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

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
        $class->setRateLimitPerUser(150);

        $this->assertEquals(['rate_limit_per_user' => 150], $class->get());
    }

    public function testSetBelowZeroRateLimitPerUser()
    {
        $class = $this->getTestClass();
        $class->setRateLimitPerUser(-10);

        $this->assertEquals(['rate_limit_per_user' => 0], $class->get());
    }

    public function testSetAbove21600RateLimitPerUser()
    {
        $class = $this->getTestClass();
        $class->setRateLimitPerUser(22000);

        $this->assertEquals(['rate_limit_per_user' => 21600], $class->get());
    }
}
