<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Rest\Helpers\Channel\GetReactionsBuilder;
use Monolog\Test\TestCase;

class GetReactionsBuilderTest extends TestCase
{
    public function testSetAfter()
    {
        $builder = new GetReactionsBuilder();
        $builder->setAfter('::after::');

        $this->assertEquals(['after' => '::after::'], $builder->get());
    }

    public function testSetLimit()
    {
        $builder = new GetReactionsBuilder();
        $builder->setLimit(25);

        $this->assertEquals(['limit' => 25], $builder->get());
    }

    public function testSetLimitGreaterThan100()
    {
        $builder = new GetReactionsBuilder();
        $builder->setLimit(150);

        $this->assertEquals(['limit' => 100], $builder->get());
    }

    public function testSetLimitLowerThan1()
    {
        $builder = new GetReactionsBuilder();
        $builder->setLimit(-50);

        $this->assertEquals(['limit' => 1], $builder->get());
    }
}
