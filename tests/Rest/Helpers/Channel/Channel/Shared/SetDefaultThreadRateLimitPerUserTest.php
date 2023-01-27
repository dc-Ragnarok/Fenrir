<?php

namespace Tests\Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

use Exan\Dhp\Rest\Helpers\Channel\Channel\Shared\SetDefaultThreadRateLimitPerUser;
use PHPUnit\Framework\TestCase;

class SetDefaultThreadRateLimitPerUserTest extends TestCase
{
    public function testSetThreadRateLimitPerUser()
    {
        $class = new class extends DummyTraitTester {
            use SetDefaultThreadRateLimitPerUser;
        };

        $class->setDefaultThreadRateLimitPerUser(5);

        $this->assertEquals(['default_thread_rate_limit_per_user' => 5], $class->get());
    }
}
